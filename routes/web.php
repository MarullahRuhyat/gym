<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Member;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Member\QRController;
use App\Http\Middleware\CheckPersonalTrainer;
use App\Http\Controllers\Admin\GajiController;
use App\Http\Controllers\Admin\ScanController;
use App\Http\Controllers\Admin\AbsenController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Member\PackageController;
use App\Http\Controllers\Member\PaymentController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Admin\JenisMemberController;
use App\Http\Controllers\Admin\TypePackageController;
use App\Http\Controllers\Member\AttendanceController;
use App\Http\Controllers\Admin\JenisLatihanController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\PersonalTraining\ProfilePersonalTraining;
use App\Http\Controllers\PersonalTraining\PersonalTrainerController;
use App\Http\Controllers\PersonalTraining\AttendanceMemberController;
use App\Http\Controllers\Member\AuthController as MemberAuthController;
use App\Http\Controllers\PersonalTraining\GajiPersonalTrainerController;
use App\Http\Controllers\Admin\PersonalTrainerController as PersonalTrainerAdminController;

Route::get('test', fn () => phpinfo());

Route::prefix('/')->group(function(){
    Route::get('/', function () {
        $appType = config('app.app_type');
        if ($appType == 'ADMIN') {
            return redirect()->route('auth.login');
        }
        return view('landing_page.index');
    });
    Route::get('/program-monthly-membership', function () {
        return view('landing_page.program_monthly_membership');
    })->name('program-monthly-membership');
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
    Route::get('/register', [MemberAuthController::class, 'register'])->name('member.register');
    Route::post('/register/process', [MemberAuthController::class, 'store1'])->name('member.register.process');
    Route::post('/register-submit', [MemberAuthController::class, 'register_submit'])->name('member.register.submit');

    Route::get('/send-otp', [MemberAuthController::class, 'send_otp'])->name('member.send-otp');
    Route::post('/get-otp', [MemberAuthController::class, 'get_otp'])->name('member.get-otp');
    Route::get('/verify-otp/{phone_number}', [MemberAuthController::class, 'verify_otp'])->name('member.verify-otp');
    Route::post('/login', [MemberAuthController::class, 'login'])->name('member.login');
    Route::post('/logout', [MemberAuthController::class, 'logout'])->name('member.logout')->middleware(Member::class);

    Route::middleware(Member::class)->group(function () {
        Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('member.dashboard');
        Route::post('/qr-code', [ProfileController::class, 'qr_code'])->name('member.qr_code');
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'profile'])->name('member.profile');
            Route::get('/edit-profile', [ProfileController::class, 'edit_profile'])->name('member.edit_profile');
            Route::post('/edit-profile/{id}', [ProfileController::class, 'edit_profile_process'])->name('member.edit-profile.process');
            // Route::get('/change-password', [ProfileController::class, 'change_password'])->name('member.change_password');
            // Route::post('/change-password', [ProfileController::class, 'change_password_process'])->name('member.change-password.process');
        });
        Route::prefix('payment')->group(function () {
            Route::get('/', [PaymentController::class, 'payment'])->name('member.payment');
            //             Route::post('/payment-callback', [PaymentController::class, 'payment_callback'])->name('member.payment.callback');

            Route::prefix('payment-callback')->group(function () {
                Route::match(['get', 'post'], '/', [PaymentController::class, 'payment_callback'])->name('member.payment.callback');
                Route::get('/payment-success', [PaymentController::class, 'payment_success'])->name('member.payment.success');
                Route::get('/payment-failed', [PaymentController::class, 'payment_failed'])->name('member.payment.failed');
                Route::get('/payment-pending', [PaymentController::class, 'payment_pending'])->name('member.payment.pending');
                Route::post('/check-payment-status', [PaymentController::class, 'check_payment_status'])->name('member.check_payment_status');
            });
        });

        Route::prefix('package')->group(function () {
            Route::get('/', [PackageController::class, 'package'])->name('member.package');
            Route::post('/select-package', [PackageController::class, 'select_package'])->name('member.select.package');
            Route::get('/selected-package-detail/{id}', [PackageController::class, 'selected_package_detail'])->name('member.selected-package-detail');
            Route::get('/subscribed-package', [PackageController::class, 'subscribed_package'])->name('member.subscribed-package');
        });
        Route::prefix('membership')->group(function () {
            // Route::post('/subscribe-membership', [MembershipController::class, 'subscribe_membership'])->name('member.subscribe_membership');
            // Route::get('/history-membership', [MembershipController::class, 'history_membership'])->name('member.history-membership');
            // Route::get('/detail-membership/{id}', [MembershipController::class, 'detail_membership'])->name('member.detail-membership');
        });
        Route::prefix('attendance')->group(function () {
            // Route::post('/check-in', [AttendanceController::class, 'check_in'])->name('member.check_in');
            // Route::post('/check-out', [AttendanceController::class, 'check_out'])->name('member.check_out');
            Route::get('/history-attendance', [AttendanceController::class, 'history_attendance'])->name('member.history-attendance');
        });
    });
});
// end member


// personal trainer
Route::prefix('personal-trainer')->middleware(CheckPersonalTrainer::class)->group(function () {
    Route::get('/dashboard', [PersonalTrainerController::class, 'dashboard'])->name('personal_trainer.dashboard');
    // attendance member
    Route::prefix('attendance-member')->group(function () {
        Route::get('/', [AttendanceMemberController::class, 'index'])->name('personal_trainer.attendance_member');
        Route::post('/{id}', [AttendanceMemberController::class, 'update'])->name('personal_trainer.update');
        // search member with name
        Route::get('/search', [AttendanceMemberController::class, 'search'])->name('personal_trainer.search');
    });

    // profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfilePersonalTraining::class, 'index'])->name('personal_trainer.profile');
        Route::post('/', [ProfilePersonalTraining::class, 'updateProfile'])->name('personal_trainer.update_profile');
        Route::post('/change-password', [ProfilePersonalTraining::class, 'changePassword'])->name('personal_trainer.change_password');
        Route::post('/edit-profile', [ProfilePersonalTraining::class, 'editProfile'])->name('personal_trainer.edit_profile');
    });
    // payment
    Route::prefix('payment')->group(function () {
        Route::get('/', [GajiPersonalTrainerController::class, 'index'])->name('personal_trainer.payment.index');
    });
});


// admin
Route::prefix('admin')->middleware(Admin::class)->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin_dashboard');
    Route::post('/ajax-get-dashboard', [DashboardAdminController::class, 'ajax_dashboard_admin'])->name('admin_ajax_dashboard');
    // personal trainer page
    Route::match(['get', 'post'], '/personal-trainer', [PersonalTrainerAdminController::class, 'index'])->name('admin_personal_trainer');
    // member page
    Route::match(['get', 'post'], '/member', [MemberController::class, 'index'])->name('admin_member');
    // Attendance page
    Route::prefix('attendance-member')->group(function () {
        Route::get('/', [AbsenController::class, 'index'])->name('admin_absen');
        Route::get('/search', [AbsenController::class, 'search'])->name('admin_search');
    });
    // salary page
    Route::match(['get', 'post'], '/salary', [GajiController::class, 'index'])->name('admin_gaji');
    Route::get('/ajax-get-bonus', [GajiController::class, 'ajax_get_bonus'])->name('admin_ajax_get_bonus');
    Route::post('/bonus', [GajiController::class, 'bonus'])->name('admin_bonus');
    Route::post('/generate-gaji', [GajiController::class, 'generate'])->name('admin_generate_gaji');
    // scan page
    Route::match(['get', 'post'], '/scan', [ScanController::class, 'index'])->name('admin_scan');
    Route::post('/ajax-post-attendance', [ScanController::class, 'post_attendance'])->name('admin_ajax_post_attendance');
    // membership page
    Route::match(['get', 'post'], '/membership-package', [JenisMemberController::class, 'index'])->name('admin_membership_package');
    // jenis latihan page
    Route::match(['get', 'post'], '/jenis-latihan', [JenisLatihanController::class, 'index'])->name('admin_jenis_latihan');
    // type package page
    Route::match(['get', 'post'], '/type-package', [TypePackageController::class, 'index'])->name('admin_type_package');
});
