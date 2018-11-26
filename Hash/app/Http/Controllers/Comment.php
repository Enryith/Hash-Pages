<?php

namespace App\Http\Controllers;

use App\Events;
use App\Repositories\Comments;
use App\Repositories\Posts;
use App\Repositories\Tags;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory as Validation;
use App\Entities;
use Illuminate\Validation\ValidationException;

class Comment extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function form()
	{
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