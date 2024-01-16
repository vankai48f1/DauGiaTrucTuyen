<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class MaintenancePermissionApi
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $is_under_maintenance = settings('maintenance_mode');
        if ($is_under_maintenance) {
            $route_name = $request->route()->getName();
            $avoidable_maintenance_routes = config('apipermissions.' . ROUTE_TYPE_AVOIDABLE_MAINTENANCE);
            if (
                (Auth::guest() && !in_array($route_name, $avoidable_maintenance_routes)) ||
                (
                    Auth::check() &&
                    !Auth::user()->is_accessible_under_maintenance &&
                    !in_array($route_name, $avoidable_maintenance_routes)
                )
            ) {
                throw new UnauthorizedException(ROUTE_REDIRECT_TO_UNDER_MAINTENANCE, 503);
            }
        }
        return $next($request);
    }
}
