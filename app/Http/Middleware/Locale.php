<?php

namespace App\Http\Middleware;

use Closure;

class Locale{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
    public function handle($request, Closure $next, string $lang)
    {
        app()->setLocale($lang);

        return $next($request);
    }
}
