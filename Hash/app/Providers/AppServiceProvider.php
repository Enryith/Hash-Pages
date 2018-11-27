<?php

namespace App\Providers;

use App\Entities\Chat;
use App\Entities\Comment;
use App\Entities\Discussion;
use App\Entities\Post;
use App\Entities\Tag;
use App\Entities\User;
use App\Repositories\Chats;
use App\Repositories\Comments;
use App\Repositories\Discussions;
use App\Repositories\Tags;
use App\Repositories\Users;
use App\Repositories\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 * @return void
	 */
	public function boot() {}

	/**
	 * Register any application services.
	 * @return void
	 */
	public function register()
	{
		$this->repository(Chats::class, Chat::class);
		$this->repository(Tags::class, Tag::class);
		$this->repository(Posts::class, Post::class);
		$this->repository(Users::class, User::class);
		$this->repository(Comments::class, Comment::class);
		$this->repository(Discussions::class, Discussion::class);
	}

	public function repository($repo, $entity){
		/** @var EntityManagerInterface $em */
		$em = $this->app['em'];

		$this->app->bind($repo, function() use ($repo, $em, $entity) {
			return new $repo($em, $em->getClassMetaData($entity));
		});
	}
}
