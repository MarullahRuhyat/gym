<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing_page');
});

// auth
Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'loginIndex'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('auth.login.process');

    // for personal trainer
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot_password');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


// member
Route::group(['prefix' => 'member', 'middleware' => 'auth'], function () {
    // contoh
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
    Route::get('/profile', [MemberController::class, 'profile'])->name('member.profile');
    Route::get('/change-password', [MemberController::class, 'changePassword'])->name('member.change_password');
    Route::post('/change-password', [MemberController::class, 'changePasswordProcess'])->name('member.change_password.process');
});

// personal trainer
Route::group(['prefix' => 'personal-trainer', 'middleware' => 'auth'], function () {
    // contoh
    Route::get('/dashboard', [PersonalTrainerController::class, 'dashboard'])->name('personal_trainer.dashboard');
    Route::get('/profile', [PersonalTrainerController::class, 'profile'])->name('personal_trainer.profile');
    Route::get('/change-password', [PersonalTrainerController::class, 'changePassword'])->name('personal_trainer.change_password');
    Route::post('/change-password', [PersonalTrainerController::class, 'changePasswordProcess'])->name('personal_trainer.change_password.process');
});