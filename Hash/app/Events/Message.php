<?php

namespace App\Events;

use App\Entities;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Message implements ShouldBroadcast
{
	public $username;
	public $message;
	public $id;

	public function __construct(Entities\Message $message, Entities\Chat $chat)
	{
		$this->id = $chat->getId();
		$this->message = $message->getMessage();
		$this->username = $message->getUser()->getUsername();
	}

	public function broadcastOn()
	{
		return new PrivateChannel("chat.{$this->id}");
	}

	public function broadcastAs()
	{
		return 'message';
	}
}