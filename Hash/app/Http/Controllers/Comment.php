<?php

namespace App\Http\Controllers;

use App\Events;
use App\Entities;
use App\Repositories\Comments;
use App\Repositories\Discussions;
use Illuminate\Contracts\Auth\Access\Gate;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Validation\Factory as Validation;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class Comment extends Controller
{
	/**
	 * @param Comments $comments
	 * @param Gate $gate
	 * @param $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function form(Comments $comments, Gate $gate, $id)
	{
		/** @var $comment Entities\Comment*/
		$comment = $comments->find($id);

		if(!$comment || $gate->denies('modify-comment', $comment))
		{
			return abort(403);
		}

		return view('comment.delete');
	}

	/**
	 * @param Comments $comments
	 * @param Gate $gate
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function delete(Comments $comments, Gate $gate, Request $request, EntityManagerInterface $em, $id)
	{
		/** @var $comment Entities\Comment*/
		$comment = $comments->find($id);

		if(!$comment || $gate->denies('modify-comment', $comment))
		{
			return abort(403);
		}

		if('Delete' == $request->get('submit'))
		{
			$em->remove($comment);
			$em->flush();
		}

		return redirect(action('Post@view', ["id" => $comment->getDiscussion()->getPost()->getId()]));
	}

	/**
	 * @param Validation $validator
	 * @param Comments $comments
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Gate $gate
	 * @param $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function edit(Validation $validator, Comments $comments, Request $request, EntityManagerInterface $em, Gate $gate, $id)
	{
		$key = "edit-{$id}";

		$valid = $validator->make($request->all(), [
			$key => "required"
		], [
			"required" => "Edit must not be empty"
		]);

		$valid->validate();
		$data = $valid->getData();

		/** @var $comment Entities\Comment*/
		$comment = $comments->find($id);

		if(!$comment || $gate->denies('modify-comment', $comment))
		{
			return abort(403);
		}

		$edit = $data[$key];
		$comment->setComment($edit);
		$em->flush();

		return redirect(action('Post@view', ["id" => $comment->getDiscussion()->getPost()->getId()]));
	}

	/**
	 * @param Discussions $discussions
	 * @param Request $request
	 * @param Guard $auth
	 * @param Validation $validator
	 * @param EntityManagerInterface $em
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws ValidationException
	 */
	public function root(Discussions $discussions, Request $request, Guard $auth, Validation $validator, EntityManagerInterface $em, $id)
	{
		$disc = $discussions->findOneById($id);

		if (!$disc) return abort(404);

		return $this->common($request, $auth, $validator, $em, $disc);
	}

	/**
	 * @param Comments $comments
	 * @param Request $request
	 * @param Guard $auth
	 * @param Validation $validator
	 * @param EntityManagerInterface $em
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws ValidationException
	 */
	public function reply(Comments $comments, Request $request, Guard $auth, Validation $validator, EntityManagerInterface $em, $id)
	{
		$parent = $comments->findOneById($id);

		if (!$parent) return abort(404);

		return $this->common($request, $auth, $validator, $em, $parent->getDiscussion(), $parent);
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
	private function common(Request $request, Guard $auth, Validation $validator, EntityManagerInterface $em, Entities\Discussion $discussion, Entities\Comment $parent = null)
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

		return redirect(action('Post@view', ["id" => $comment->getDiscussion()->getPost()->getId()]));
	}
}