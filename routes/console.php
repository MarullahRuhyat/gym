<?php

use App\Jobs\ProcessSalary;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

// Artisan::command('inspire', function () {
//     Log::info('test scheduler', [
//         'test scheduler '
//     ]);
//     return 'test scheduler ';
// })->purpose('Display an inspiring quote')->everyMinute();



Artisan::command('process_salary', function () {
    ProcessSalary::dispatch();
    Log::info('process_salary scheduler', [
        'process_salary scheduler'
    ]);
})->purpose('process_salary')->monthlyOn(16, '12:59');



// Schedule::call(function () {
//     Log::info('test scheduler', [
//         'test scheduler '
//     ]);
// })->everyMinute();
