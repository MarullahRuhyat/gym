<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentCashController extends Controller
{
    public function index()
    {
        return view('admin.payment_cash');
    }

    public function cash_acc()
    {
       
    }

    public function cash_rej()
    {
       
    }
}
