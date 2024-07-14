<?php
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Middleware\CheckPersonalTrainer;
use App\Http\Controllers\Admin\GajiController;
use App\Http\Controllers\Admin\ScanController;
use App\Http\Controllers\Admin\AbsenController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\JenisMemberController;
use App\Http\Controllers\Admin\JenisLatihanController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\PersonalTraining\PersonalTrainerController;
use App\Http\Controllers\PersonalTraining\AttendanceMemberController;
use App\Http\Controllers\Admin\PersonalTrainerController as PersonalTrainerAdminController;

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
Route::prefix('member')->middleware('auth')->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
    Route::get('/profile', [MemberController::class, 'profile'])->name('member.profile');
    Route::get('/change-password', [MemberController::class, 'changePassword'])->name('member.change_password');
    Route::post('/change-password', [MemberController::class, 'changePasswordProcess'])->name('member.change_password.process');
});


// personal trainer
Route::prefix('personal-trainer')->middleware(CheckPersonalTrainer::class)->group(function () {
    Route::get('/dashboard', [PersonalTrainerController::class, 'dashboard'])->name('personal_trainer.dashboard');
    // attendance member
    Route::prefix('attendance-member')->group(function () {
        Route::get('/', [AttendanceMemberController::class, 'index'])->name('personal_trainer.attendance_member');
        Route::post('/{id}', [AttendanceMemberController::class, 'update'])->name('personal_trainer.update');
        // search member with name
        Route::get('/searchName', [AttendanceMemberController::class, 'searchName'])->name('personal_trainer.searchName');
        Route::get('/searchDate', [AttendanceMemberController::class, 'searchDate'])->name('personal_trainer.searchDate');
    });

    // payment
    Route::prefix('payment')->group(function () {
        Route::get('/', [PersonalTrainerController::class, 'payment'])->name('personal_trainer.payment');
    });
});


// admin
Route::prefix('admin')->middleware(Admin::class)->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin_dashboard');
    // personal trainer page
    Route::match(['get', 'post'], '/personal-trainer', [PersonalTrainerAdminController::class, 'index'])->name('admin_personal_trainer');
    // member page
    Route::match(['get', 'post'], '/member', [MemberController::class, 'index'])->name('admin_member');
    // Attendance page
    Route::get('/attendance', [AbsenController::class, 'index'])->name('admin_absen');
    // salary page
    Route::get('/salary', [GajiController::class, 'index'])->name('admin_gaji');
    // scan page
    Route::get('/scan', [ScanController::class, 'index'])->name('admin_scan');
    Route::post('/ajax-post-attendance', [ScanController::class, 'post_attendance'])->name('admin_ajax_post_attendance');
    // membership page
    Route::match(['get', 'post'], '/membership-package', [JenisMemberController::class, 'index'])->name('admin_membership_package');
    // membership page
    Route::match(['get', 'post'], '/jenis-latihan', [JenisLatihanController::class, 'index'])->name('admin_jenis_latihan');
});
