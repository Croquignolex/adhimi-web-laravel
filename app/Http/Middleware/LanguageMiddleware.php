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
        $language = $request->session()->get('language', LanguageEnum::French->value);

        if(!App::isLocale($language)) {
            App::setLocale($language);
        }

        return $next($request);
    }
}
