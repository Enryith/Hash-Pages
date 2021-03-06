<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot()
	{
		parent::boot();
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map()
	{
		$this->mapAjaxRoutes();
		$this->mapWebRoutes();
		$this->mapAuthRoutes();
		$this->mapGuestRoutes();
	}

	/**
	 * Define the "web" routes for the application.
	 *
	 * These routes all receive session state, CSRF protection, etc.
	 *
	 * @return void
	 */
	protected function mapWebRoutes()
	{
		Route::middleware('web')
			 ->namespace($this->namespace)
			 ->group(base_path('routes/web.php'));
	}

	/**
	 * Defines any routes that require authentication.
	 */
	protected function mapAuthRoutes()
	{
		Route::middleware(['web', "auth"])
			->namespace($this->namespace)
			->group(base_path('routes/auth.php'));
	}

	/**
	 * Defines routes that explicitly do not require authentication.
	 */
	protected function mapGuestRoutes()
	{
		Route::middleware(['web', "guest"])
			->namespace($this->namespace)
			->group(base_path('routes/guest.php'));
	}

	/**
	 * Define the "ajax" routes for the application.
	 *
	 * Like web, these routes require states. They always fall under /ajax/...
	 *
	 * @return void
	 */
	protected function mapAjaxRoutes()
	{
		Route::prefix('ajax')
			->middleware('web')
			->namespace($this->namespace)
			->group(base_path('routes/ajax.php'));
	}
}
