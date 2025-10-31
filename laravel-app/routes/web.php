<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\App;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Ruta simple para cambiar idioma (persistir en sesión). En una app real, mover a middleware/proveedor.
Route::get('lang/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'es'])) {
        session(['app_locale' => $lang]);
        App::setLocale($lang);
    }
    return redirect()->back();
})->name('lang.switch');
