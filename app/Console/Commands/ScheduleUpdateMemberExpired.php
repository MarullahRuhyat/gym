<?php

namespace App\Console\Commands;

use App\Jobs\UpdateExpiredMembers;
use Illuminate\Console\Command;

class ScheduleUpdateMemberExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:schedule-update-member-expired';

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
        UpdateExpiredMembers::dispatch();
    }
}
