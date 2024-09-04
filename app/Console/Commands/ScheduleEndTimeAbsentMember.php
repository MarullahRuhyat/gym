<?php

namespace App\Console\Commands;

use App\Jobs\EndTimeAbsent;
use Illuminate\Console\Command;

class ScheduleEndTimeAbsentMember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:schedule-end-time-absent-member';

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
        EndTimeAbsent::dispatch();
    }
}
