<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', config('app.locale'));
        $locale = in_array($locale, ['ar', 'en'], true) ? $locale : 'ar';

        App::setLocale($locale);

        $rtl = $locale === 'ar';
        View::share('rtl', $rtl);
        View::share('arrow', $rtl ? '←' : '→');

        return $next($request);
    }
}
