<?php

namespace App\Http\Middleware;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Enums\LanguageEnum;
use Closure;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if(!session()->has('language')) {
            session(['language' => config('app.fallback_locale')]);
        }

        $activeLanguage = session('language');

        if(in_array($activeLanguage, LanguageEnum::values()))
        {
            if(App::getLocale() != $activeLanguage) {
                App::setLocale($activeLanguage);
            }
        }

        return $next($request);
    }
}
