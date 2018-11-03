<?php
namespace App\Http\Controllers;

use App\Repositories\Posts;
use App\Repositories\Tags;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory as Validation;
use App\Entities;
use Illuminate\Validation\ValidationException;

class Post extends Controller
{
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
			->select("p", "d", "t");

		if ($auth->check())
		{
			//If we are logged in, fetch any votes
			$query->leftJoin("d.votes", "v", "WITH", "v.user = :user")
				->setParameter("user", $auth->user())
				->addSelect("v");
		}

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
		$em->persist($discussion);
		$em->persist($comment);
		$em->flush();
		return redirect("/post/{$post->getId()}");
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

		//Send user to the post they just created
		return redirect("/post/{$post->getId()}");
	}

	/**
	 * @param Posts $posts
	 * @param $id
	 * @return \Illuminate\View\View
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function view(Posts $posts, $id)
	{
		$post = $posts->createQueryBuilder("p")
			->leftJoin("p.discussions", "d")
			->leftJoin("d.tag", "t")
			->select("p, d, t")
			->where("p = :p")
			->setParameter("p", $id)
			->getQuery()
			->getOneOrNullResult();

		if($post instanceof Entities\Post)
		{
			return view('post.view')->with(compact('post'));
		}

		return abort(404);
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
		}

		return $tag;
	}
}
