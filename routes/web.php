<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/properties', \App\Livewire\Admin\Properties::class)->name('admin.properties');
    Route::get('/users', \App\Livewire\Admin\Users::class)->name('admin.users');
    Route::get('/reservations', \App\Livewire\Admin\Reservations::class)->name('admin.reservations');
    Route::get('/inquiries', \App\Livewire\Admin\Inquiries::class)->name('admin.inquiries');
    Route::get('/reviews', \App\Livewire\Admin\Reviews::class)->name('admin.reviews');
    Route::get('/property-types', \App\Livewire\Admin\PropertyTypes::class)->name('admin.property-types');
    Route::get('/cities', \App\Livewire\Admin\Cities::class)->name('admin.cities');

    // Settings
    Route::get('/settings', fn () => redirect()->route('admin.settings.profile'))->name('admin.settings');
    Route::get('/settings/profile', \App\Livewire\Admin\Settings\Profile::class)->name('admin.settings.profile');
    Route::get('/settings/password', \App\Livewire\Admin\Settings\Password::class)->name('admin.settings.password');
    Route::get('/settings/delete', \App\Livewire\Admin\Settings\DeleteAccount::class)->name('admin.settings.delete');

    Route::post('/logout', function () {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    })->name('admin.logout');
});
