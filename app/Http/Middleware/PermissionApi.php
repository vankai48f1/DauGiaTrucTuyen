<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class PermissionApi
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
        $permission = has_permission($request->route()->getName(), null, false, true);
        if ($permission === true) {
            return $next($request);
        }
        throw new UnauthorizedException('Unauthorized Access', 401);
    }
}
