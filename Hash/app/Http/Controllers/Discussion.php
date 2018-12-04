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
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function form(Discussions $discussions, Gate $gate, $id)
	{
		/** @var $discussion Entities\Discussion*/
		$discussion = $discussions->find($id);

		if (!$discussion || $gate->denies('admin', $discussion))
		{
			return abort(403);
		}

		return view('discussion.delete');
	}

	/**
	 * @param Discussions $discussions
	 * @param Gate $gate
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function delete(Discussions $discussions, Request $request, EntityManagerInterface $em, Gate $gate, $id)
	{
		/** @var $discussion Entities\Discussion*/
		$discussion = $discussions->find($id);

		if (!$discussion || $gate->denies('admin', $discussion))
		{
			return abort(403);
		}

		if ('Delete' == $request->get('submit'))
		{
			$em->remove($discussion);
			$em->flush();
		}

		return redirect(action('Post@view', [$discussion->getPost()->getId()]));
	}
}
