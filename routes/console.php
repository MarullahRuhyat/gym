<?php

use App\Jobs\ProcessNotifMemberActive;
use App\Jobs\ProcessNotifMemberExpired;
use App\Jobs\ProcessSalary;
use App\Jobs\UpdateExpiredMembers;
use App\Jobs\UpdateInactiveMembers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Artisan::command('process_salary', function () {
    ProcessSalary::dispatch();
    Log::info('process_salary scheduler', [
        'process_salary scheduler'
    ]);
})->purpose('process_salary')->monthlyOn(16, '12:59');

Artisan::command('process_notif_member_inactive', function () {
    ProcessNotifMemberActive::dispatch();
    Log::info('process_notif_member_inactive scheduler', [
        'process_notif_member_inactive scheduler'
    ]);
})->purpose('process_notif_member_inactive')->dailyAt('13:53');

Artisan::command('process_notif_member_expired', function () {
    ProcessNotifMemberExpired::dispatch();
    Log::info('process_notif_member_expired scheduler', [
        'process_notif_member_expired scheduler'
    ]);
})->purpose('process_notif_member_expired')->dailyAt('13:53');

Artisan::command('process_update_member_expired', function () {
    UpdateExpiredMembers::dispatch();
    Log::info('process_update_member_expired scheduler', [
        'process_update_member_expired scheduler'
    ]);
})->purpose('process_update_member_expired')->dailyAt('21:28');

Artisan::command('process_update_member_inactive', function () {
    UpdateInactiveMembers::dispatch();
    Log::info('process_update_member_inactive scheduler', [
        'process_update_member_inactive scheduler'
    ]);
})->purpose('process_update_member_inactive')->dailyAt('21:28');
