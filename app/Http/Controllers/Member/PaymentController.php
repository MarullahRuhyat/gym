<?php

namespace App\Http\Controllers\Member;

use Midtrans\Config;
use App\Models\Payment;
use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$clientKey = config('midtrans.client_key');
        Config::$is3ds = true;
        Config::$isSanitized = true;
    }
    public function payment(Request $request)
    {

        $amount = DB::table('gym_membership_packages')->where('id', $request->submit_package_id)->pluck('price')->first();
        $user = DB::table('users')->where('id', $request->submit_user_id)->first();
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $amount,
            ),
            'customer_details' => array(
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone_number,
            ),
        );

        DB::table('payments')->insert([
            'order_id' => $params['transaction_details']['order_id'],
            'user_id' => $request->submit_user_id,
            'gym_membership_packages' => $request->submit_package_id,
            'amount' => $amount,
            'payment_method' => 'midtrans',
            'status' => 'pending',
        ]);

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('member.payment.payment_details', compact('snapToken'));
    }

    public function payment_callback(Request $request)
{
    try {
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        // Log untuk debugging
        Log::info('Payment Notification: ', [
            'Order ID' => $orderId,
            'STATUS TRANSACTION' => $transaction,
            'Payment Type' => $type,
            'Fraud Status' => $fraud
        ]);

        $data = Payment::where('order_id', $orderId)->first();

        // Pastikan data tersedia sebelum proses lebih lanjut
        if (!$data) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        $payment = Payment::firstOrCreate(
            ['order_id' => $orderId],
            [
                'user_id' => $data->user_id,
                'gym_membership_packages' => $data->gym_membership_packages,
                'membership_id' => $data->membership_id,
                'amount' => $data->gross_amount,
                'payment_method' => $type,
                'status' => 'pending'
            ]
        );

        if ($transaction == 'settlement') {
            $payment->status = 'paid';
        } elseif ($transaction == 'cancel' || $transaction == 'deny') {
            $payment->status = 'failed';
        } elseif ($transaction == 'pending') {
            $payment->status = 'pending';
        } elseif ($transaction == 'expire') {
            $payment->status = 'expired';
        }

        $payment->save();
        return response()->json(['status' => 'success', 'message' => 'Notification processed']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}

    public function payment_success()
    {
        return view('member.payment.payment_success');
    }

}
