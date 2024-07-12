<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsentMember extends Model
{
    protected $fillable = [
        'member_id',
        'personal_trainer_id',
        'date',
        'start_time',
        'end_time',
        'qr_code',
        'path_qr_code',
        'jenis_latihan',
    ];
    // Ensure that timestamps are converted to the correct timezone
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Accessor to ensure timezone conversion
    public function getStartTimeAttribute($value)
    {
        if ($value == null) {
            return null;
        }
        $carbonDateTime = Carbon::parse($value);

        $hour = $carbonDateTime->format('H-i-s');
        return  $hour;
    }

    public function getEndTimeAttribute($value)
    {
        if ($value == null) {
            return null;
        }
        $carbonDateTime = Carbon::parse($value);

        $hour = $carbonDateTime->format('H-i-s');
        return  $hour;
    }

    // Define the one-to-one relationship with the User model
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    use HasFactory;
}
