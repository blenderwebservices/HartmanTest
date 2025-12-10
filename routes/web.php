<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Test;

Route::get('/', Test::class)->name('test');
