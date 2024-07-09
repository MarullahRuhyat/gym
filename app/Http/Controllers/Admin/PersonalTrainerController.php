<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonalTrainerController extends Controller
{
    //
    function index(Request $request)
    {
        return view('admin.personal_trainer');
    }
}
