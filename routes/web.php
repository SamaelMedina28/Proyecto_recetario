<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Categories\Index;
use App\Livewire\Categories\Create;
use App\Livewire\Recipes\Create as RecipeCreate;
use App\Livewire\Recipes\Show;
use App\Livewire\Recipes\Edit;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    
    Route::get('categories', Index::class)->name('categories.index');
    Route::get('categories/create', Create::class)->name('categories.create');
    Route::get('recipes/create', RecipeCreate::class)->name('recipes.create');
    Route::get('recipes/{recipe}/edit', Edit::class)->name('recipes.edit');
    Route::get('recipes/{recipe}', Show::class)->name('recipes.show');
});

require __DIR__.'/auth.php';
