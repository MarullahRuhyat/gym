<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Membership;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateInactiveMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tanggal_sekarang = Carbon::now();
        $tanggal_target = $tanggal_sekarang->subDay()->toDateString();
        User::where('end_date', $tanggal_target)
            ->where('role', 'member')
            ->update(['status' => 'inactive']);
        Membership::where('end_date', $tanggal_target)
            ->where('is_active', 1)
            ->update(['is_active' => 0]);

        Log::info('process_inactive_member', []);
    }
}
