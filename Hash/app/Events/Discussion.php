<?php

namespace App\Events;

use App\Entities;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Discussion implements ShouldBroadcast
{
	public $id;
	public $discTitle;
	public $postTitle;
	public $author;
	public $comment;

	public function __construct(Entities\Discussion $discussion)
	{
		$this->id = $discussion->getPost()->getId();
		$this->discTitle = $discussion->getTitle();
		$this->postTitle = $discussion->getPost()->getTitle();
		$this->author = $discussion->getComments()[0]->getAuthor()->getUsername();
		$this->comment = $discussion->getComments()[0]->getComment();
	}

	public function broadcastOn()
	{
		return new Channel('feed');
	}

	public function broadcastAs()
	{
		return 'discussion';
	}
}