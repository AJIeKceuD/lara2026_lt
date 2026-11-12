<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function terms($locale)
    {
        app()->setLocale($locale);
        return view('.pages.' . $locale . '.terms');
    }

    public function privacy($locale)
    {
        app()->setLocale($locale);
        return view('.pages.' . $locale . '.privacy');
    }
}
