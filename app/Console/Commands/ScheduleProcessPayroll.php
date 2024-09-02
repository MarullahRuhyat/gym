<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Jobs\ProcessPayroll;

class ScheduleProcessPayroll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:schedule-process-payroll';

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
        $startDate = Carbon::today()->subMonth()->format('Y-m-d');
        $endDate = Carbon::today()->subDay()->format('Y-m-d');
        ProcessPayroll::dispatch($startDate, $endDate);
    }
}
