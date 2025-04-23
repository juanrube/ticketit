<?php

namespace Juanrube\Ticketit\Middleware;

use Closure;
use Juanrube\Ticketit\Models\Agent;
use Juanrube\Ticketit\Models\Setting;

class IsAdminMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Agent::isAdmin()) {
            return $next($request);
        }

        return redirect()->route(Setting::grab('main_route').'.index')
            ->with('warning', trans('ticketit::lang.you-are-not-permitted-to-access'));
    }
}
