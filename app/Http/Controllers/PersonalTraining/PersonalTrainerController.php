<?php

namespace App\Http\Controllers\PersonalTraining;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonalTrainerController extends Controller
{
    public function dashboard()
    {
        return view('personal_training.dashboard');
    }

    public function attendanceMember()
    {
        return view('personal_training.attendance_member');
    }
}
