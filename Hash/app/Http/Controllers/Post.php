<?php
namespace App\Http\Controllers;

use App\Events;
use App\Repositories\Posts;
use App\Repositories\Tags;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory as Validation;
use App\Entities;
use Illuminate\Validation\ValidationException;

class Post extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function form()
	{
		return view('post.form');
	}

	/**
	 * @param Guard $auth
	 * @param Posts $posts
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Guard $auth, Posts $posts)
	{
		$query = $posts->createQueryBuilder("p")
			->leftJoin("p.discussions", "d")
			->leftJoin("d.tag", "t")
			->select("p", "d", "t")
			->orderBy('p.recentActivity', "DESC");

		$this->leftJoinVotes($query, $auth);
		$table = $posts->paginate($query->getQuery(), 20);
		return view('post.index')->with(compact('table'));
	}

	/**
	 * @param Tags $tags
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Validation $validator
	 * @param Guard $auth
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws ValidationException
	 */
	public function discussion(Tags $tags, Request $request, EntityManagerInterface $em, Validation $validator, Guard $auth, $id)
	{
		/** @var Entities\Post $post */
		$post = $em->find("App\Entities\Post", $id);

		//Post must exist if you want to discuss it!
		if (!$post) abort(404);

		/** @var $user Entities\User */
		$user = $auth->user();
		$valid = $validator->make($request->all(), [
			'title' => "required|min:2",
			'comment' => "required|min:2",
			'tag' => "required|max:20|alpha_num",
		]);

		$valid->validate();
		$data = $valid->getData();

		//Get a new tag or reuse one that exists
		$tag = $this->getTag($em, $tags, $data["tag"]);

		//Make sure the tag is not already added
		$count = $em->createQueryBuilder()
			->select("COUNT(d) as count")
			->from("App\Entities\Post", "p")
			->where("p = :post")
			->leftJoin("p.discussions", "d", "WITH", "d.tag = :tag")
			->setParameter("tag", $tag)
			->setParameter("post", $post)
			->getQuery()->getArrayResult();

		if ($count[0]["count"] > 0)
		{
			throw ValidationException::withMessages([
				'tag' => [trans("validation.discussion")],
			]);
		}

		//Create the discussion
		$discussion = new Entities\Discussion($post, $tag, $user, $data["title"]);
		$comment = new Entities\Comment($discussion, $user, $data["comment"]);
		$discussion->addComment($comment);

		$post->bump();

		event(new Events\Discussion($discussion));

		$em->persist($discussion);
		$em->persist($comment);
		$em->flush();
		return redirect("/post/{$post->getId()}");
	}

	/**
	 * @param Request $request
	 * @param Guard $auth
	 * @param Validation $validator
	 * @param EntityManagerInterface $em
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws ValidationException
	 */
	public function commentRoot(Request $request, Guard $auth, Validation $validator, EntityManagerInterface $em, $id)
	{
		/** @var Entities\Discussion $disc */
		$disc = $em->find("App\Entities\Discussion", $id);
		//TODO: Make sure this exists

		return $this->commentHelper($request, $auth, $validator, $em, $disc);
	}

	/**
	 * @param Request $request
	 * @param Guard $auth
	 * @param Validation $validator
	 * @param EntityManagerInterface $em
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws ValidationException
	 */
	public function comment(Request $request, Guard $auth, Validation $validator, EntityManagerInterface $em, $id)
	{
		/** @var Entities\Comment $parent */
		$parent = $em->find("App\Entities\Comment", $id);
		//TODO: Make sure this exists

		return $this->commentHelper($request, $auth, $validator, $em, $parent->getDiscussion(), $parent);
	}

	/**
	 * @param Request $request
	 * @param Guard $auth
	 * @param Validation $validator
	 * @param EntityManagerInterface $em
	 * @param Entities\Discussion $discussion
	 * @param Entities\Comment|null $parent
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws ValidationException
	 */
	private function commentHelper(Request $request, Guard $auth, Validation $validator, EntityManagerInterface $em, Entities\Discussion $discussion, Entities\Comment $parent = null)
	{
		/** @var $user Entities\User */
		$user = $auth->user();
		$field = $parent ? "reply-{$parent->getId()}" : "reply";

		$valid = $validator->make($request->all(), [
			$field => "required|max:1000",
		], [
			"required" => "Comment is required",
			"max" => "Comment cannot be over :max characters"
		]);

		$valid->validate();
		$data = $valid->getData();

		$comment = new Entities\Comment($discussion, $user, $data[$field], $parent);
		$discussion->addComment($comment);
		$post = $discussion->getPost();

		$post->bump();

		event(new Events\Comment($comment));

		$em->persist($comment);
		$em->flush();

		return redirect("/post/{$comment->getDiscussion()->getPost()->getId()}");
	}

	/**
	 * @param Tags $tags
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Validation $validator
	 * @param Guard $auth
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Tags $tags, Request $request, EntityManagerInterface $em, Validation $validator, Guard $auth)
	{
		/** @var $user Entities\User */
		$user = $auth->user();
		$valid = $validator->make($request->all(), [
			'title' => "required|min:2",
			'body' => "required|min:10",
			'link' => "sometimes|nullable|url",
			'tag' => "required|max:20|alpha_num",
		]);

		$valid->validate();
		$data = $valid->getData();

		//Get a new tag or reuse one that exists
		$tag = $this->getTag($em, $tags, $data["tag"]);

		//Create post and initial discussion with tag
		$post = new Entities\Post($user, $data["title"], trim($data["link"]), $data["body"]);

		$discussion = new Entities\Discussion($post, $tag, $user, "Original Post");
		$em->persist($discussion);
		$em->persist($post);
		$em->flush();

		event(new Events\Post($post));

		//Send user to the post they just created
		return redirect("/post/{$post->getId()}");
	}

	/**
	 * @param Guard $auth
	 * @param Posts $posts
	 * @param $id
	 * @return \Illuminate\View\View
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function view(Guard $auth, Posts $posts, $id)
	{
		//how many left joins can we have?
		$query = $posts->createQueryBuilder("p")
			->leftJoin("p.discussions", "d")
			->leftJoin("d.comments", "c")
			->leftJoin("c.author", 'a')
			->leftJoin("c.children", "l")
			->leftJoin("d.tag", "t")
			->where("p = :post")
			->setParameter("post", $id)
			->orderBy("c.id", "ASC")
			->select("p", "d", "t", "c", 'a', 'l');

		$this->leftJoinVotes($query, $auth);
		$post = $query->getQuery()->getOneOrNullResult();

		if($post instanceof Entities\Post)
		{
			return view('post.view')->with(compact('post'));
		}

		return abort(404);
	}

	private function leftJoinVotes(QueryBuilder $query, Guard $auth)
	{
		if ($auth->check())
		{
			//If we are logged in, fetch any votes
			$query->leftJoin("d.votes", "v", "WITH", "v.user = :user")
				->setParameter("user", $auth->user())
				->addSelect("v");
		}
	}

	private function getTag(EntityManagerInterface $em, Tags $tags, $name)
	{
		//Find one by will be null if it does not exist
		$tag = $tags->findOneBy(["tag" => $name]);

		if (!$tag)
		{
			//Create tag for the user if it does not exist.
			$tag = new Entities\Tag($name);
			$em->persist($tag);
			$em->flush();
		}

		return $tag;
	}

	/**
	 * @param Posts $posts
	 * @param Gate $gate
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function deleteForm(Posts $posts, Gate $gate, $id)
	{
		/** @var $post Entities\Post*/
		$post = $posts->find($id);

		if(!$post || $gate->denies('view-post', $post)){
			return abort(403);
		}

		return view('post.delete');
	}

	/**
	 * @param Posts $posts
	 * @param Gate $gate
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function delete(Posts $posts, Gate $gate, Request $request, EntityManagerInterface $em, $id)
	{
		/** @var $post Entities\Post */
		$post = $posts->find($id);
		if (!$post || $gate->denies('view-post', $post)) {
			return abort(403);
		}

		if ('Delete' == $request->get('submit')) {
			$post->setIsDeleted(true);
			$em->flush();
		}

		return redirect(action('Post@index'));
	}

	public function edit(Guard $auth, Posts $posts, $id)
	{

	}
}
