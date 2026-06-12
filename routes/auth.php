<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    // Öffentliche Selbst-Registrierung ist deaktiviert: Alle Accounts
    // (Admin, Lehrer, Klassen-Accounts) werden serverseitig angelegt
    // (Seeder bzw. beim Erstellen einer Klasse). Ein offener /register-
    // Endpunkt erlaubt sonst jedem einen eingeloggten Account.
    // Zum Reaktivieren die folgende Zeile wieder einkommentieren:
    // Volt::route('register', 'pages.auth.register')->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});
