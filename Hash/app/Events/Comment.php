<?php

namespace App\Events;

use App\Entities;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Comment implements ShouldBroadcast
{
	public $id;
	public $comment;
	public $author;
	public $discTitle;
	public $postTitle;

	public function __construct(Entities\Comment $comment)
	{
		$this->id = $comment->getDiscussion()->getPost()->getId();
		$this->comment = $comment->getComment();
		$this->author = $comment->getAuthor()->getUsername();
		$this->discTitle = $comment->getDiscussion()->getTitle();
		$this->postTitle = $comment->getDiscussion()->getPost()->getTitle();
	}

	public function broadcastOn()
	{
		return new Channel('feed');
	}

	public function broadcastAs()
	{
		return 'comment';
	}
}