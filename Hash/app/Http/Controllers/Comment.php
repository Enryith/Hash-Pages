<?php

namespace App\Http\Controllers;

use App\Repositories\Comments;
use Illuminate\Contracts\Auth\Access\Gate;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Entities;

class Comment extends Controller
{
	/**
	 * @param Comments $comments
	 * @param Gate $gate
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function form(Comments $comments, Gate $gate, $id)
	{
		/** @var $comment Entities\Comment*/
		$comment = $comments->find($id);
		if(!$comment || $gate->denies('view-comment', $comment)){
			return abort(403);
		}

		return view('comment.delete');
	}

	/**
	 * @param Comments $comments
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Guard $auth
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function delete(Comments $comments, Request $request, EntityManagerInterface $em, Guard $auth, $id)
	{
		/** @var $comment Entities\Comment*/
		$comment = $comments->find($id);
		if('Delete' == $request->get('submit')){
			$comment->setComment('[DELETED]');
			$em->flush();
		}

		return redirect(action('Post@view', ["id" => $comment->getDiscussion()->getPost()->getId()]));
	}
}