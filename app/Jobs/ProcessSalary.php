<?php

namespace App\Jobs;

use App\Models\GajiPersonalTrainer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessSalary implements ShouldQueue
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

        $results = DB::select(
            "
            SELECT COUNT(*) as jumlah_waktu , u.id as id 
            FROM absent_members am left join users u on u.id = am.personal_trainer_id 
            WHERE  am.personal_trainer_id is not NULL 
            AND am.date BETWEEN '2024-06-25' AND '2024-07-24'
            GROUP by am.personal_trainer_id 
            "
        );

        foreach ($results as $row) {
            $gaji = new GajiPersonalTrainer();
            $gaji->personal_trainer_id = $row->id;
            $gaji->jumlah_pertemuan = $row->jumlah_waktu;
            $gaji->gaji_per_pertemuan = 200000;
            $gaji->bulan_gaji = '2024-07-25';
            $gaji->save();
        }
        Log::info('process_salary queue', [
            'process_salary queue'
        ]);
    }
}
