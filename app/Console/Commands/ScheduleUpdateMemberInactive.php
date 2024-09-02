<?php

namespace App\Console\Commands;

use App\Jobs\UpdateInactiveMembers;
use Illuminate\Console\Command;

class ScheduleUpdateMemberInactive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:schedule-update-member-inactive';

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
        UpdateInactiveMembers::dispatch();
    }
}
