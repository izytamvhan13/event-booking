<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerStore']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/pimpinan/dashboard', [DashboardController::class, 'index'])->name('pimpinan.dashboard');
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    Route::post('/user/gacha', [UserDashboardController::class, 'gachaSlot'])->name('user.gacha');

    Route::get('/venues/browse', [VenueController::class, 'browse'])->name('venues.browse');
    Route::resource('bookings', BookingController::class);
    Route::post('/bookings/{booking}/forward', [BookingController::class, 'forward'])->name('bookings.forward');
    Route::resource('venues', VenueController::class);
    Route::resource('users', UserController::class);
    Route::resource('facilities', FacilityController::class);

    Route::get('/laporan', [App\Http\Controllers\ReportController::class, 'index'])->name('laporan.index');

    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [App\Http\Controllers\NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.readAll');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::view('/bantuan', 'help.index')->name('help.index');
    
    Route::view('/bantuan', 'help.index')->name('help.index');

    Route::get('/templates', [App\Http\Controllers\DocumentTemplateController::class, 'index'])->name('templates.index');
    Route::post('/templates', [App\Http\Controllers\DocumentTemplateController::class, 'store'])->name('templates.store');
    Route::get('/templates/{template}/download', [App\Http\Controllers\DocumentTemplateController::class, 'download'])->name('templates.download');
    Route::delete('/templates/{template}', [App\Http\Controllers\DocumentTemplateController::class, 'destroy'])->name('templates.destroy');
});