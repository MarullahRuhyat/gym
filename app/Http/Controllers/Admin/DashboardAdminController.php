<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    //
    function index(Request $request)
    {
        return view('admin.dashboard');
    }
}