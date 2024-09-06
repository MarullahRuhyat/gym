<?php

namespace App\Jobs;

use App\Models\AbsentMember;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EndTimeAbsent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $time = "23:59:59";
        $today = Carbon::today();
    
        DB::table('absent_members')
            ->whereNull('date')
            ->update([
                'date' => $today,
                'updated_at' => Carbon::now(),
            ]);
    
        DB::table('absent_members')
            ->whereNotNull('date')
            ->whereNull('start_time')
            ->update([
                'start_time' => $time,
                'updated_at' => Carbon::now(),
            ]);
    
        DB::table('absent_members')
            ->whereNotNull('date')
            ->whereNotNull('start_time')
            ->whereNull('end_time')
            ->update([
                'end_time' => $time,
                'updated_at' => Carbon::now(),
            ]);
            
    }
}
