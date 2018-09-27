<?php

namespace App\Providers;

use App\Entities\Post;
use App\Entities\User;
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
		/** @var EntityManagerInterface $em */
		$em = $this->app['em'];

		$this->app->bind(Users::class, function() use ($em) {
			return new Users(
				$em, $em->getClassMetaData(User::class)
			);
		});

		$this->app->bind(Posts::class, function() use ($em) {
			return new Posts(
				$em, $em->getClassMetaData(Post::class)
			);
		});
	}
}
