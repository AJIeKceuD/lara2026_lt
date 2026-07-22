<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FormContactUsController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Редирект с корня
Route::get('/', function () {
    // Определяем язык по заголовкам браузера
    $locale = substr(request()->getPreferredLanguage(), 0, 2);

    // Проверяем, поддерживается ли язык
    if (!in_array($locale, ['en', 'zh'])) {
        $locale = 'en';
    }

    return redirect("/{$locale}");
});

Route::group([
    'prefix' => '{locale?}',
    'where' => ['locale' => 'en|zh'],
    // 'middleware' => 'setlocale' // если есть middleware
], function ($locale = null) {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
});

Route::any('/contact-us', [FormContactUsController::class, 'store'])->name('contact-us.store');

// ВСЁ ОСТАЛЬНОЕ (любой другой двухбуквенный код) → редирект на /en
Route::get('/{locale}', function ($locale) {
    return redirect('/en');
})->where('locale', '[a-z]{2}');

