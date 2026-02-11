<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    protected $locales = ['en', 'ta', 'si'];

    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', config('app.locale'));
        if (in_array($locale, $this->locales, true)) {
            app()->setLocale($locale);
        }
        return $next($request);
    }
}
