<?php

namespace App\Http\Controllers;

class LocaleController extends Controller
{
    private const SUPPORTED = ['es', 'en', 'fr'];

    public function switch(string $locale)
    {
        if (!in_array($locale, self::SUPPORTED, true)) {
            abort(404);
        }

        session(['locale' => $locale]);

        return redirect(url()->previous('/'));
    }
}
