<?php

namespace App\Http\Controllers;

use App\Entities\Discussion;
use App\Entities\Vote;
use App\Repositories\Tags;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Entities;

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

	/**
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Guard $auth
	 * @return array|\Illuminate\Http\JsonResponse
	 * @throws \Doctrine\DBAL\ConnectionException
	 */
	function vote(Request $request, EntityManagerInterface $em, Guard $auth)
	{
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

		try
		{
			//Update the votes in one transaction
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

	private function update(EntityManagerInterface $em, Entities\User $user, $type, $id)
	{
		//Find the discussion based on ID
		/** @var Discussion $discussion */
		$discussion = $em->getRepository("App\Entities\Discussion")->find($id);

		if (!$discussion)
		{   //Fail if the discussion is not found
			return response()->json([
				self::FAIL => "invalid discussion"
			], 400);
		}

		/** @var Vote $vote */
		$vote = $em->getRepository("App\Entities\Vote")->findOneBy([
			"user" => $user,
			"discussion" => $discussion
		]);

		if (!$vote)
		{   //They do not have a vote yet, add it in
			$vote = new Vote($user, $discussion);
			$vote->setType($type);
			$discussion->delta($type, 1);
			$em->persist($vote);
			return $this->valid("created", $discussion);
		}

		if ($type == $vote->getType())
		{   //Have a vote, user wants to remove it because they are voting again
			$em->remove($vote);
			$discussion->delta($type, -1);
			return $this->valid("removed", $discussion);
		}

		//Have a vote, user does not want it removed, so change it
		$discussion->delta($vote->getType(), -1);
		$discussion->delta($type, 1);
		$vote->setType($type);
		return $this->valid("changed", $discussion);
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
