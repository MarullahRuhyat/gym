<?php

use App\Http\Controllers\Admin\AbsenController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\GajiController;
use App\Http\Controllers\Admin\MemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\PersonalTraining\PersonalTrainerController;
use App\Http\Middleware\Admin;
use App\Http\Controllers\Admin\PersonalTrainerController as PersonalTrainerAdminController;
use App\Http\Controllers\Member\AuthController as MemberAuthController;
use App\Http\Controllers\Member\ProfileController;

Route::get('/', function () {
    $appType = config('app.app_type');
    if ($appType == 'ADMIN') {
        return redirect()->route('auth.login');
    }
    return view('landing_page');
});

Route::get('/starter-page', function () {
    return view('personal_training.pages-starter-page');
});

// auth
Route::prefix('auth')->group(function () {
    // login member
    Route::get('/login-member', [AuthController::class, 'loginAdminIndex'])->name('auth.login.member');
    Route::post('/login-member', [AuthController::class, 'loginMemberProcess'])->name('auth.login_member.process');
    // login admin dan personal trainer
    Route::get('/login', [AuthController::class, 'loginAdminIndex'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'loginAdminProcess'])->name('auth.login.process');
    // otp
    Route::get('/otp', [AuthController::class, 'otpIndex'])->name('auth.otp');
    Route::post('/otp', [AuthController::class, 'otpProcess'])->name('auth.otp.process');


    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    // for personal trainer
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot_password');
});

// member
Route::prefix('member')->group(function () {
    Route::get('/select-package', [PackageController::class, 'select_package'])->name('member.select-package');
    Route::get('/register', [MemberAuthController::class, 'register'])->name('member.register');
    Route::post('/register', [MemberAuthController::class, 'register_process'])->name('member.register.process');
    Route::get('/send-otp', [MemberAuthController::class, 'send_otp'])->name('member.send-otp');
    Route::post('/get-otp', [MemberAuthController::class, 'get_otp'])->name('member.get-otp');
    Route::get('/verify-otp/{phone_number}', [MemberAuthController::class, 'verify_otp'])->name('member.verify-otp');
    Route::post('/login', [MemberAuthController::class, 'login'])->name('member.login');
    Route::get('/logout', [MemberAuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('member.dashboard');
        Route::prefix('profile')->group(function () {
            Route::get('/edit-profile', [ProfileController::class, 'edit_profile'])->name('member.edit_profile');
            Route::post('/edit-profile', [ProfileController::class, 'edit_profile_process'])->name('member.edit-profile.process');
            Route::get('/change-password', [ProfileController::class, 'change_password'])->name('member.change_password');
            Route::post('/change-password', [ProfileController::class, 'change_password_process'])->name('member.change-password.process');
        });
        Route::prefix('membership')->group(function () {
            Route::post('/subscribe-membership', [MembershipController::class, 'subscribe_membership'])->name('member.subscribe_membership');
            Route::get('/history-membership', [MembershipController::class, 'history_membership'])->name('member.history-membership');
            Route::get('/detail-membership/{id}', [MembershipController::class, 'detail_membership'])->name('member.detail-membership');
        });
        Route::prefix('payment')->group(function () {
            Route::get('/payment', [PaymentController::class, 'payment'])->name('member.payment');
            Route::post('/payment-callback', [PaymentController::class, 'payment_callback'])->name('member.payment.callback');
        });
        Route::prefix('attendance')->group(function () {
            Route::post('/check-in', [AttendanceController::class, 'check_in'])->name('member.check_in');
            Route::post('/check-out', [AttendanceController::class, 'check_out'])->name('member.check_out');
            Route::get('/history-attendance', [AttendanceController::class, 'history_attendance'])->name('member.history-attendance');
        });
    });
});
// end member


// personal trainer
Route::prefix('personal-trainer')->group(function () {
    Route::get('/dashboard', [PersonalTrainerController::class, 'dashboard'])->name('personal_trainer.dashboard');
    Route::get('attendance-member', [PersonalTrainerController::class, 'attendanceMember'])->name('personal_trainer.attendance_member');
});


// admin
Route::prefix('admin')->middleware(Admin::class)->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin_dashboard');
    Route::get('/personal-trainer', [PersonalTrainerAdminController::class, 'index'])->name('admin_personal_trainer');
    Route::get('/member', [MemberController::class, 'index'])->name('admin_member');
    Route::get('/absen', [AbsenController::class, 'index'])->name('admin_absen');
    Route::get('/gaji', [GajiController::class, 'index'])->name('admin_gaji');
});
