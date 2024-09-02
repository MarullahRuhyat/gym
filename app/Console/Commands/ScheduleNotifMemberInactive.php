<?php

namespace App\Console\Commands;

use App\Jobs\ProcessNotifMemberActive;
use Illuminate\Console\Command;


class ScheduleNotifMemberInactive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:schedule-notif-member-inactive';

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
        ProcessNotifMemberActive::dispatch();
    }
}
