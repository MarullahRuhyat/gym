<?php

namespace App\Http\Controllers\Member;

use Midtrans\Config;
use App\Models\Payment;
use Midtrans\Notification;
use Midtrans\Transaction;
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
        $start_date = $request->submit_start_date;
        $gym_membership_packages = DB::table('gym_membership_packages')->where('id', $request->submit_package_id)->pluck('duration_in_days')->first();
        $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $gym_membership_packages . ' days'));
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

        DB::table('memberships')->insert([
            'user_id' => $request->submit_user_id,
            'gym_membership_packages' => $request->submit_package_id,
            'start_date' => date('Y-m-d'),
            'end_date' => $end_date,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('payments')->insert([
            'order_id' => $params['transaction_details']['order_id'],
            'membership_id' => DB::table('memberships')->latest()->first()->id,
            'user_id' => $request->submit_user_id,
            'gym_membership_packages' => $request->submit_package_id,
            'amount' => $amount,
            'payment_method' => 'midtrans',
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // menambahkan snap token ke table payment
        DB::table('payments')->where('order_id', $params['transaction_details']['order_id'])->update([
            'snap_token' => $snapToken
        ]);

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

    public function check_payment_status(Request $request)
    {
        $orderId = $request->input('order_id');

        if (!$orderId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order ID tidak tersedia.'
            ]);
        }

        try {
            // Mengecek status transaksi di database Anda
            $payment = Payment::where('order_id', $orderId)->first();
            if (!$payment) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order ID not found.'
                ]);
            }

            // Memanggil API Midtrans untuk mendapatkan status transaksi terbaru
            $transactionStatus = Transaction::status($orderId);

            if ($transactionStatus->transaction_status === 'pending') {
                return response()->json([
                    'status' => 'pending',
                    'token' => $payment->snap_token
                ]);
            } else {
                // Perbarui status pembayaran di database Anda
                $payment->status = $transactionStatus->transaction_status;
                $payment->save();

                return response()->json([
                    'status' => $transactionStatus->transaction_status
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function payment_success()
    {
        return view('member.payment.payment_success');
    }

}
