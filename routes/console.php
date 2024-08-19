<?php

use App\Jobs\ProcessNotifMemberActive;
use App\Jobs\ProcessNotifMemberExpired;
use App\Jobs\ProcessPayroll;
use App\Jobs\UpdateExpiredMembers;
use App\Jobs\UpdateInactiveMembers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Artisan::command('process_payroll', function () {
    $startDate = Carbon::today()->subMonth()->format('Y-m-d');
    $endDate = Carbon::today()->subDay()->format('Y-m-d');
    ProcessPayroll::dispatch($startDate, $endDate);
    Log::info('process_payroll scheduler', [
        'process_payroll scheduler'
    ]);
})->purpose('process_payroll')->monthlyOn(config('app.scheduler.payroll_date'), config('app.scheduler.payroll_time'));

Artisan::command('process_notif_member_inactive', function () {
    ProcessNotifMemberActive::dispatch();
    Log::info('process_notif_member_inactive scheduler', [
        'process_notif_member_inactive scheduler'
    ]);
})->purpose('process_notif_member_inactive')->dailyAt(config('app.scheduler.notif_member_inactive_time'));

Artisan::command('process_notif_member_expired', function () {
    ProcessNotifMemberExpired::dispatch();
    Log::info('process_notif_member_expired scheduler', [
        'process_notif_member_expired scheduler'
    ]);
})->purpose('process_notif_member_expired')->dailyAt(config('app.scheduler.notif_member_expired_time'));

Artisan::command('process_update_member_expired', function () {
    UpdateExpiredMembers::dispatch();
    Log::info('process_update_member_expired scheduler', [
        'process_update_member_expired scheduler'
    ]);
})->purpose('process_update_member_expired')->dailyAt(config('app.scheduler.update_member_expired_time'));

Artisan::command('process_update_member_inactive', function () {
    UpdateInactiveMembers::dispatch();
    Log::info('process_update_member_inactive scheduler', [
        'process_update_member_inactive scheduler'
    ]);
})->purpose('process_update_member_inactive')->dailyAt(config('app.scheduler.update_member_expired_time'));
