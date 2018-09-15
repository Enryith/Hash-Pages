<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return string
	 */
	protected function redirectTo($request)
	{
		$logout = $request->path() == "auth/logout";
		$request->session()->flash("alert-danger", $logout ? trans("auth.login-to-logout") : trans("auth.required"));
		return '/auth/login';
	}
}
