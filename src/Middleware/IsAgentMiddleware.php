<?php



namespace Juanrube\Ticketit\Middleware;

use Closure;
use Juanrube\Ticketit\Models\Agent;
use Juanrube\Ticketit\Models\Setting;

class IsAgentMiddleware
{

    public function handle($request, Closure $next)
    {
        if (Agent::isAgent() || Agent::isAdmin()) {
            return $next($request);
        }

        return redirect()->route(Setting::grab('main_route').'.index')
            ->with('warning', trans('ticketit::lang.you-are-not-permitted-to-access'));
    }
}
