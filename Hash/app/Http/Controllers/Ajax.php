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

	private $request;

	function __construct(Request $request)
	{
		$this->request = $request;
	}

	function test()
	{
		return [self::OK => "It Works!"];
	}

	function tags(Tags $tags)
	{
		return $tags->findAllLike($this->request->get("q"));
	}

	function vote(EntityManagerInterface $em, Guard $auth)
	{
		/** @var Entities\User $user */
		$user = $auth->user();

		//Fail if parameters are missing
		if (!$this->request->has("discussion", "type"))
		{
			return response()->json([
				self::FAIL => "missing parameter"
			], 400);
		}

		//Get the data from the request
		$data = $this->request->toArray();
		$type = $data["type"];

		//Fail if the vote type is invalid
		if (!Vote::isValid($type))
		{
			return response()->json([
				self::FAIL => "invalid type"
			], 400);
		}

		/** @var Discussion $discussion */
		$discussion = $em->getRepository("App\Entities\Discussion")
			->find($data["discussion"]);

		//Fail if the discussion is not found
		if (!$discussion) {
			return response()->json([
				self::FAIL => "invalid discussion"
			], 400);
		}

		/** @var Vote $vote */
		$vote = $em->getRepository("App\Entities\Vote")
			->findOneBy(["user" => $user, "discussion" => $discussion]);

		//They do not have a vote yet, add it in
		if (!$vote)
		{
			$vote = new Vote($user, $discussion);
			$vote->setType($type);
			$discussion->delta($type, 1);
			$em->persist($vote);
			$em->flush();
			return $this->valid("created", $discussion, $type);
		}

		//Have a vote, user wants to remove it because they are voting again
		if ($type == $vote->getType())
		{
			$em->remove($vote);
			$discussion->delta($type, -1);
			$em->flush();
			return $this->valid("removed", $discussion);
		}

		//Have a vote, user does not want it removed, so change it
		$discussion->delta($vote->getType(), -1);
		$vote->setType($type);
		$discussion->delta($type, 1);
		$em->flush();
		return $this->valid("changed", $discussion, $type);
	}

	private function valid($status, Discussion $discussion, $type = null)
	{
		$ret = [
			self::OK => $status,
			"votes" => [
				Vote::AGREE => $discussion->getCachedAgree(),
				Vote::DISAGREE => $discussion->getCachedDisagree(),
			]
		];

		if ($type) {
			$ret["to"] = $type;
		}

		return $ret;
	}
}
