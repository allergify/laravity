<?php

namespace Laravity\Http\Middleware;

use Auth;
use Closure;
use Laravity\UserActivity;
use Laravity\Events\UserActivityEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserActivityMonitoringMiddleware
{
    protected $exclude = [
        'place.suitable',
        'offline',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check() && !in_array($request->route()->getName(), $this->exclude)) {
            try {
                $userActivity = new UserActivity(
                    Auth::user(),
                    $request,
                    $response
                );

                event(new UserActivityEvent($userActivity));
            } catch (\Exception $e) {
                if (config('app.debug')) {
                    dd($e);
                }
            }
        }

        return $response;
    }
}
