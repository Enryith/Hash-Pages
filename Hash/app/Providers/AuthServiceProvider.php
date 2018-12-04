<?php

namespace App\Providers;

use App\Entities\Chat;
use App\Entities\Comment;
use App\Entities\Post;
use App\Entities\User;
use App\Entities\Discussion;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model' => 'App\Policies\ModelPolicy',
	];

	public function adminAuth(User $user){
		return $user && ($user->isAdmin() || $user->getId() == 1);
	}

	/**
	 * Register any authentication / authorization services.
	 *
	 * @param Gate $gate
	 * @return void
	 */
	public function boot(Gate $gate)
	{
		$this->registerPolicies();

		$gate->before([$this, 'adminAuth']);

		$gate->define('admin', [$this, 'adminAuth']);

		$gate->define('view-chat', function (User $user, Chat $chat) {
			return $chat->getUsers()->contains($user);
		});

		$gate->define('modify-comment', function (User $user, Comment $comment) {
			return (!$comment->isDeleted() && $comment->getAuthor() === $user);
		});

		$gate->define('modify-post', function(User $user, Post $post) {
			return ($post->getAuthor() === $user);
		});
	}
}
