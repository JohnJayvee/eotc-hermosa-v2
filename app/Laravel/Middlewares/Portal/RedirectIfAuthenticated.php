<?php

namespace App\Laravel\Middlewares\Portal;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticated
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Auth::logout();
            session()->flash('notification-status', 'error');
            session()->flash('notification-msg', 'Restricted area. Unauthorized access.');

            return redirect()->route('web.main.index');

            return new RedirectResponse(route('web.transaction.create'));
        }

        if ($request->routeIs('web.login') && Auth::guard('customer')->check()) {
            return redirect()->route('web.main.index');
        }

        /* if ($request->routeIs('web.main.index') && ! Auth::guard('customer')->check()) {
            return redirect()->route('web.login');
        } */

        return $next($request);
    }
}
