<?php

namespace App\Http\Controllers;

use App\Entities\Discussion;
use App\Entities\Vote;
use App\Repositories\Chats;
use App\Repositories\Tags;
use App\Repositories\Users;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Entities;
use Illuminate\Validation\Factory as Validation;


class Ajax extends Controller
{
	/**
	 * Use this value when something ok happened.
	 */
	const OK = "success";
	const FAIL = "error";

	function test()
	{
		return [self::OK => "It Works!"];
	}

	function tags(Request $request, Tags $tags)
	{
		return $tags->findAllLike($request->get("q"));
	}

	function users(Request $request, Users $users)
	{
		return $users->findAllLike($request->get("q"));
	}

	public function message(Chats $chats, Gate $gate, Request $request, EntityManagerInterface $em, Guard $auth, $id){
		/** @var Entities\Chat $chat */
		$chat = $chats->find($id);

		if(!$chat || $gate->denies("view-chat", $chat)){
			return abort(404);
		}

		$text = trim($request->get("message"));

		if($text == ""){
			return abort(400);
		}

		/** @var  $user Entities\User */
		$user = $auth->user();
		$message = new Entities\Message($user, $chat, $text);

		$em->persist($message);
		$em->flush();

		return [];
	}

	/**
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Guard $auth
	 * @return array|\Illuminate\Http\JsonResponse
	 * @throws \Doctrine\DBAL\ConnectionException
	 */
	function vote(Request $request, EntityManagerInterface $em, Guard $auth)
	{
		/** @var EntityManager $em */
		/** @var Entities\User $user */
		$user = $auth->user();

		//Fail if parameters are missing
		if (!$request->has("discussion", "type"))
		{
			return response()->json([
				self::FAIL => "missing parameter"
			], 400);
		}

		//Get the data from the request
		$data = $request->toArray();

		//Fail if the vote type is invalid
		if (!Vote::isValid($data["type"]))
		{
			return response()->json([
				self::FAIL => "invalid type"
			], 400);
		}

		//Lock the database row from read-writes
		//Otherwise, two people could vote at the
		//same time and break the score deltas
		$em->getConnection()->beginTransaction();

		//Update the votes in one transaction
		try
		{
			$response = $this->update($em, $user, $data["type"], $data["discussion"]);
			$em->flush();
			$em->getConnection()->commit();
			return $response;
		}
		catch(\Exception $e)
		{
			$em->getConnection()->rollBack();
			return response()->json([
				self::FAIL => "lock exception"
			], 500);
		}
	}

	/**
	 * @param EntityManager $em
	 * @param Entities\User $user
	 * @param $type
	 * @param $id
	 * @return array|\Illuminate\Http\JsonResponse
	 * @throws \Doctrine\ORM\ORMException
	 */
	private function update(EntityManager $em, Entities\User $user, $type, $id)
	{
		//Find the discussion based on ID
		/** @var Discussion $discussion */
		$discussion = $em->getRepository("App\Entities\Discussion")
			->find($id, LockMode::PESSIMISTIC_WRITE);

		//Fail if the discussion is not found
		if (!$discussion)
		{
			return response()->json([
				self::FAIL => "invalid discussion"
			], 400);
		}

		/** @var Vote $vote */
		$vote = $em->getRepository("App\Entities\Vote")->createQueryBuilder("v")
			->where("v.user = :user")
			->andWhere("v.discussion = :discussion")
			->setParameter("user", $user)
			->setParameter("discussion", $discussion)
			->getQuery()
			->setLockMode(LockMode::PESSIMISTIC_WRITE)
			->getOneOrNullResult();

		if (!$vote)
		{
			//They do not have a vote yet, add it in
			$vote = new Vote($user, $discussion);
			$vote->setType($type);
			$discussion->delta($type, 1);
			$em->persist($vote);
			return $this->valid("created", $discussion);
		}
		else if ($type == $vote->getType())
		{
			//Have a vote, user wants to remove it because they are voting again
			$em->remove($vote);
			$discussion->delta($type, -1);
			return $this->valid("removed", $discussion);
		}
		else
		{
			//Have a vote, user does not want it removed, so change it
			$discussion->delta($vote->getType(), -1);
			$discussion->delta($type, 1);
			$vote->setType($type);
			return $this->valid("changed", $discussion);
		}
	}

	private function valid($status, Discussion $discussion)
	{
		return [
			self::OK => $status,
			"votes" => [
				Vote::AGREE => $discussion->getCachedAgree(),
				Vote::DISAGREE => $discussion->getCachedDisagree(),
			]
		];
	}
}
