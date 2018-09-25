<?php

namespace App\Providers;

use App\Entities\User;
use App\Repositories\User as UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(UserRepository::class, function($app) {
			// This is what Doctrine's EntityRepository needs in its constructor.
			return new UserRepository(
				$app['em'],
				$app['em']->getClassMetaData(User::class)
			);
		});
	}
}
