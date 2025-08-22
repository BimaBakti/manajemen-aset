<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Settings routes
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Asset Management routes
    Volt::route('assets', 'assets.index')->name('assets.index');
    Volt::route('assets/create', 'assets.create')->name('assets.create');
    Volt::route('assets/{asset}', 'assets.show')->name('assets.show');
    Volt::route('assets/{asset}/edit', 'assets.edit')->name('assets.edit');

    Volt::route('categories', 'categories.index')->name('categories.index');
    Volt::route('categories/create', 'categories.create')->name('categories.create');
    Volt::route('categories/{category}/edit', 'categories.edit')->name('categories.edit');

    Volt::route('locations', 'locations.index')->name('locations.index');
    Volt::route('locations/create', 'locations.create')->name('locations.create');
    Volt::route('locations/{location}/edit', 'locations.edit')->name('locations.edit');

    // Requests & Loans routes
    Volt::route('asset-requests', 'asset-requests.index')->name('asset-requests.index');
    Volt::route('asset-requests/create', 'asset-requests.create')->name('asset-requests.create');
    Volt::route('asset-requests/{assetRequest}', 'asset-requests.show')->name('asset-requests.show');

    Volt::route('asset-loans', 'asset-loans.index')->name('asset-loans.index');
    Volt::route('asset-loans/create', 'asset-loans.create')->name('asset-loans.create');
    Volt::route('asset-loans/{assetLoan}', 'asset-loans.show')->name('asset-loans.show');

    // Procurement routes (admin/procurement only)
    Volt::route('procurement-requests', 'procurement-requests.index')->name('procurement-requests.index');
    Volt::route('procurement-requests/create', 'procurement-requests.create')->name('procurement-requests.create');
    Volt::route('procurement-requests/{procurementRequest}', 'procurement-requests.show')->name('procurement-requests.show');

    Volt::route('vendors', 'vendors.index')->name('vendors.index');
    Volt::route('vendors/create', 'vendors.create')->name('vendors.create');
    Volt::route('vendors/{vendor}/edit', 'vendors.edit')->name('vendors.edit');

    // Administration routes (admin only)
    Volt::route('users', 'users.index')->name('users.index');
    Volt::route('users/create', 'users.create')->name('users.create');
    Volt::route('users/{user}/edit', 'users.edit')->name('users.edit');

    Volt::route('departments', 'departments.index')->name('departments.index');
    Volt::route('departments/create', 'departments.create')->name('departments.create');
    Volt::route('departments/{department}/edit', 'departments.edit')->name('departments.edit');
});

require __DIR__.'/auth.php';
