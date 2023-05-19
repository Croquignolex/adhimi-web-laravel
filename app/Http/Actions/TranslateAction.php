<?php

namespace App\Http\Actions;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TranslateAction extends Controller
{
    /**
     * @param Request $request
     * @param string $language
     * @return RedirectResponse
     */
    public function __invoke(Request $request, string $language): RedirectResponse
    {
        $request->session()->put('language', $language);

        return back();
    }
}
