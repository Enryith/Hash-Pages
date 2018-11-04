<?php

namespace App\Events;

use App\Entities;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Post implements ShouldBroadcast
{
	public $title;
	public $body;
	public $author;

	public function __construct(Entities\Post $post)
	{
		$this->title = $post->getTitle();
		$this->body = $post->getBody();
		$this->author = $post->getAuthor()->getUsername();

	}

	public function broadcastOn()
	{
		return new Channel('feed');
	}

	public function broadcastAs()
	{
		return 'post';
	}
}