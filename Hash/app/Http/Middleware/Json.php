<?php

namespace App\Http\Middleware;

use Closure;

class Json
{
	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Closure $next
	 * @return string
	 */
	public function handle($request, Closure $next) {
		//Force the request to look like an AJAX request.
		$request->headers->add(["X-Requested-With" => "XMLHttpRequest", "Accept" => "*/*"]);
		return $next($request);
	}
}
