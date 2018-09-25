<?php

namespace App\Providers;

use App\Repositories\User;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$users = EntityManager::getRepository(User::class);
		$this->app->instance(User::class, $users);
	}
}
