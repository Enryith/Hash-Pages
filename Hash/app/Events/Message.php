<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Message implements ShouldBroadcast
{
	public $message;

	public function __construct($message)
	{
		$this->message = $message;
	}

	public function broadcastOn()
	{
		return new Channel('message');
	}

	public function broadcastAs()
	{
		return 'message';
	}
}