<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Test;
use Illuminate\Support\Facades\Route;

Route::get('locale/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'es'])) {
        abort(400);
    }

    if (auth()->check()) {
        auth()->user()->update(['locale' => $locale]);
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('locale.switch');

Route::get('/', Test::class)->name('test');
