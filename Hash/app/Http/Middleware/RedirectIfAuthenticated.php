<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if (Auth::guard($guard)->check())
		{
			$login = $request->path() == "auth/login";
			$request->session()->flash("alert-danger", $login ? trans("auth.logout-to-login") : trans("auth.exist"));
			return redirect('/');
		}

		return $next($request);
	}
}
