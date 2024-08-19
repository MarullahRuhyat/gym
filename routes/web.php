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
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\JenisMemberController;
use App\Http\Controllers\Admin\JenisLatihanController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\PersonalTraining\PersonalTrainerController;
use App\Http\Controllers\PersonalTraining\AttendanceMemberController;
use App\Http\Controllers\Admin\PersonalTrainerController as PersonalTrainerAdminController;
use App\Http\Controllers\Admin\TypePackageController;
use App\Http\Controllers\Member\AuthController as MemberAuthController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\PackageController;
use App\Http\Controllers\Member\PaymentController;
use App\Http\Controllers\Member\AttendanceController;
use App\Http\Controllers\PersonalTraining\ProfilePersonalTraining;
use App\Http\Controllers\PersonalTraining\GajiPersonalTrainerController;

Route::get('test', fn () => phpinfo());

Route::prefix('/')->group(function(){
    Route::get('/', function () {
        $appType = config('app.app_type');
        if ($appType == 'ADMIN') {
            return redirect()->route('auth.login');
        }
        return redirect()->route('landing_page_user');
    })->name('landing_page');
    Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing_page_user');
    Route::get('/program-monthly-membership', function () {
        return view('landing_page.program_monthly_membership');
    })->name('program-monthly-membership');

    Route::get('/personal-body-care-by-pt', function () {
        return view('landing_page.program_personal_body_care_by_pt');
    })->name('personal-body-care-by-pt');

    Route::get('/personal-body-care-by-owner', function () {
        return view('landing_page.program_personal_body_care_by_owner');
    })->name('personal-body-care-by-owner');

    Route::get('/one-day', function () {
        return view('landing_page.program_one_day');
    })->name('one-day');

<<<<<<< HEAD
    // post question
=======

    // post question 
>>>>>>> e261be1 (update code untuk looping testimony)
    Route::post('/post-question', [LandingPageController::class, 'post_question'])->name('post_question');
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
    Route::get('/register', [MemberAuthController::class, 'register'])->name('member.register_select');
    Route::get('/register-form', [MemberAuthController::class, 'register_form'])->name('member.register-form');
    Route::post('/register-form', [MemberAuthController::class, 'register_form_process'])->name('member.register-form.process');
    Route::get('/register-multi-user', [MemberAuthController::class, 'register_multi_user_get_package'])->name('member.register-get-package');
    Route::post('/get-package-detail', [MemberAuthController::class, 'get_package_detail'])->name('member.get-package-detail');
    Route::post('/register/check-member-terkait', [MemberAuthController::class, 'check_member_terkait'])->name('member.check-member-terkait');

    Route::get('/payment', [PaymentController::class, 'payment'])->name('member.payment');

    Route::get('/login', [MemberAuthController::class, 'send_otp'])->name('member.send-otp');
    Route::post('/get-otp', [MemberAuthController::class, 'get_otp'])->name('member.get-otp');
    Route::get('/verify-otp/{phone_number}', [MemberAuthController::class, 'verify_otp'])->name('member.verify-otp');
    Route::post('/post-login', [MemberAuthController::class, 'login'])->name('member.login');
    Route::post('/logout', [MemberAuthController::class, 'logout'])->name('member.logout')->middleware(Member::class);


    Route::get('/package/register', [PackageController::class, 'package_register'])->name('member.package.register');
    Route::post('/package/select-package', [PackageController::class, 'select_package'])->name('member.select.package');
    Route::get(('/guest/payment'), [PaymentController::class, 'guest_payment'])->name('member.guest.payment');

    Route::middleware(Member::class)->group(function () {
        Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('member.dashboard');
        Route::post('/qr-code', [ProfileController::class, 'qr_code'])->name('member.qr_code');
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'profile'])->name('member.profile');
            Route::get('/edit-profile', [ProfileController::class, 'edit_profile'])->name('member.edit_profile');
            Route::post('/edit-profile/{id}', [ProfileController::class, 'edit_profile_process'])->name('member.edit-profile.process');
        });
        Route::prefix('payment')->group(function () {
            // Route::get('/', [PaymentController::class, 'payment'])->name('member.payment');
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
            // Route::get('/selected-package-detail/{id}', [PackageController::class, 'selected_package_detail'])->name('member.selected-package-detail');
            Route::post('/submit-package', [PackageController::class, 'submit_package'])->name('member.submit-package');
            Route::get('/subscribed-package', [PackageController::class, 'subscribed_package'])->name('member.subscribed-package');
        });
        Route::prefix('attendance')->group(function () {
            Route::get('/history-attendance', [AttendanceController::class, 'history_attendance'])->name('member.history-attendance');
        });
    });
});
// end member


// personal trainer
Route::prefix('personal-trainer')->middleware(CheckPersonalTrainer::class)->group(function () {
    Route::get('/dashboard', [PersonalTrainerController::class, 'dashboard'])->name('personal_trainer.dashboard');
    Route::get('/personal_trainer_dashboard', [PersonalTrainerController::class, 'personal_trainer_dashboard'])->name('personal_trainer_dashboard');
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
        // search gaji personal trainer
        Route::get('/search', [GajiPersonalTrainerController::class, 'search'])->name('personal_trainer.payment.search');
    });
});


// admin
Route::prefix('admin')->middleware(Admin::class)->group(function () {
    // custom template
    Route::post('/custom-template', [DashboardAdminController::class, 'custom_template'])->name('admin_custom_template');
    // dashboard page
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
