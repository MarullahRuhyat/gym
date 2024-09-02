<?php

namespace App\Console\Commands;

use App\Jobs\ProcessNotifMemberExpired;
use Illuminate\Console\Command;

class ScheduleNotifMemberExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:schedule-notif-member-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        ProcessNotifMemberExpired::dispatch();
    }
}
