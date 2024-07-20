<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateExpiredMembers implements ShouldQueue
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
        $tanggal_sekarang = Carbon::now(); // Tanggal sekarang
        $tanggal_target = $tanggal_sekarang->subYear()->subDay()->toDateString();
        User::where('end_date', $tanggal_target)
            ->where('role', 'member')
            ->update(['status' => 'expired']);
        Log::info('process_expired_member', []);
    }
}
