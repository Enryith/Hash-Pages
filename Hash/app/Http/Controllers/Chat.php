<?php

namespace App\Http\Controllers;

use App\Repositories\Chats;
use App\Repositories\Users;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validation;
use App\Entities;
use Illuminate\Validation\ValidationException;
use Doctrine\ORM\EntityManagerInterface;

class Chat
{
	/**
	 * @param Users $users
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Validation $validator
	 * @param Guard $auth
	 * @return string
	 * @throws ValidationException
	 */
	public function store(Users $users, Request $request, EntityManagerInterface $em, Validation $validator, Guard $auth){
		/** @var Entities\User $user */
		$user = $auth->user();
		$valid = $validator->make($request->all(), [
			'users' => "required",
		]);

		$valid->validate();
		$data = $valid->getData();
		$ids = explode(",", $data["users"]);
		$chat = new Entities\Chat($data["title"]);
		$chat->addUser($user);
		foreach ($ids as $id){
			/** @var  $result Entities\User*/
			$result = $users->find($id);
			$chat->addUser($result);
		}
		$em->persist($chat);
		$em->flush();

		return redirect(action("Chat@index"));
	}

	public function index(Guard $auth, Chats $chats)
	{
		/** @var Entities\User $user */
		$user = $auth->user();
		$table = $chats->paginateUserChats($user);
		return view('chat.index')->with(compact('table'));
	}

	public function view(Chats $chats, Gate $gate, $id){
		$chat = $chats->find($id);
		if(!$chat || $gate->denies('view-chat', $chat)){
			return abort(404);
		}

		return view('chat.view')->with(compact('chat'));
	}
}