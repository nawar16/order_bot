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
    public function handle($request, Closure $next)
    {
		if (session()->has('lang')) {
			app()->setLocale(session()->get('lang'));
		} else {
			session()->put('lang', 'en');
			app()->setLocale(session()->get('lang'));
		}

        return $next($request);
    }
}
