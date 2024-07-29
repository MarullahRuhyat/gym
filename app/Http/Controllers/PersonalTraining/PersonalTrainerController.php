<?php

namespace App\Http\Controllers\PersonalTraining;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonalTrainerController extends Controller
{
    public function dashboard()
    {
        return view('personal_training.dashboard');
    }
    
    public function payment() {
        return view('personal_training.payment');
    }
}
