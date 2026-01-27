<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Test;

Route::get('locale/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'es'])) {
        abort(400);
    }

    if (auth()->check()) {
        auth()->user()->update(['locale' => $locale]);
    }

    session(['locale' => $locale]);
    session()->save();

    return redirect()->back();
})->name('locale.switch');

Route::get('/register', \App\Livewire\Register::class)->name('register');
Route::get('/results/{result}', \App\Livewire\Results::class)->name('results');
Route::get('/documentation', \App\Livewire\Documentation::class)->name('documentation');
Route::get('/', Test::class)->name('test');
Route::get('/test2', \App\Livewire\Test2::class)->name('test2');
