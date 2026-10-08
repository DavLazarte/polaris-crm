<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('locale', $request->cookie('locale', config('app.locale', 'es')));

        if (in_array($locale, ['es', 'en', 'pt', 'fr'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
