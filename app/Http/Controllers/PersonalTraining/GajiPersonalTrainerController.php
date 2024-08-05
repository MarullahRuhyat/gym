<?php

namespace App\Http\Controllers\PersonalTraining;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GajiPersonalTrainerController extends Controller
{
    public function index() {
        $user = auth()->user();
        return view('personal_training.payment', compact('user'));
    }
}
