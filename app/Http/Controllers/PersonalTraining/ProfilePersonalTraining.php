<?php

namespace App\Http\Controllers\PersonalTraining;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilePersonalTraining extends Controller
{
    public function index() {
        return view('personal_training.profile');
    }
}
