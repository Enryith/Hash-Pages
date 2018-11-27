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
		if(!$discussion || $gate->denies('view-discussion', $discussion)){
			return abort(403);
		}

		return view('discussion.delete');
	}

	/**
	 * @param Discussions $discussions
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Doctrine\ORM\ORMException
	 */
	public function delete(Discussions $discussions, Request $request, EntityManagerInterface $em, $id)
	{
		/** @var $discussion Entities\Discussion*/
		$discussion = $discussions->find($id);
		$return = $discussion->getPost()->getId();
		if('Delete' == $request->get('submit')){
			$discussion->setIsDeleted(true);
			$em->flush();
		}

		return redirect(action('Post@view', [$return]));
	}
}