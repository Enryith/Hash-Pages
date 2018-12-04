<?php

namespace App\Http\Controllers;

use App\Repositories\Discussions;
use Illuminate\Contracts\Auth\Access\Gate;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Entities;

class Discussion extends Controller
{
	/**
	 * @param Discussions $discussions
	 * @param Gate $gate
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function form(Discussions $discussions, Gate $gate, $id)
	{
		/** @var $discussion Entities\Discussion*/
		$discussion = $discussions->find($id);
		$ability = ($discussion->getPost()->getDiscussions()[0] === $discussion) ? 'view-discussion-head' : 'view-discussion';

		if(!$discussion || $gate->denies($ability, $discussion)){
			return abort(403);
		}

		return view('discussion.delete');
	}

	/**
	 * @param Discussions $discussions
	 * @param Gate $gate
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Gate $gate
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function delete(Discussions $discussions, Request $request, EntityManagerInterface $em, Gate $gate, $id)
	{
		/** @var $discussion Entities\Discussion*/
		$discussion = $discussions->find($id);
		$ability = ($discussion->getPost()->getDiscussions()[0] === $discussion) ? 'view-discussion-head' : 'view-discussion';
		if(!$discussion || $gate->denies($ability, $discussion)){
			return abort(403);
		}
		$return = $discussion->getPost()->getId();

		$ability = ($discussion->getPost()->getDiscussions()[0] === $discussion) ? 'view-discussion-head' : 'view-discussion';

		if(!$discussion || $gate->denies($ability, $discussion)){
			return abort(403);
		}

		if('Delete' == $request->get('submit')){
			$discussion->setIsDeleted(true);
			$em->flush();
		}

		return redirect(action('Post@view', [$return]));
	}
}