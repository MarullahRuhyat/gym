<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymMembershipPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'duration_in_days',
        'personal_trainer_quota',
    ];
}
