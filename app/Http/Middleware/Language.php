<?php

namespace App\Http\Middleware;

use Closure;

class Language
{
    public function handle($request, Closure $next)
    {

        $locale = $request->segment(1);
        if (check_language($locale) == null) {
            $locale = '';
        }
        set_language($locale, settings('lang'));

        return $next($request);
    }
}
