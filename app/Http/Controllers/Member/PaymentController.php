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
        $user_id = DB::table('users')->where('phone_number', $request->payment_phone_number)->pluck('id')->first();
        $start_date = $request->submit_start_date;
        $duration = DB::table('gym_membership_packages')->where('id', $request->submit_package_id)->pluck('duration_in_days')->first();
        $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $duration . ' days'));
        // $amount = DB::table('gym_membership_packages')->where('id', $request->submit_package_id)->pluck('price')->first();
        $amount = $request->payment_amount;
        $user = DB::table('users')->where('id', $user_id)->first();
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

        // DB::table('memberships')->insert([
        //     'user_id' => $user_id,
        //     'gym_membership_packages' => $request->submit_package_id,
        //     'start_date' => date('Y-m-d'),
        //     'end_date' => $end_date,
        //     'duration_in_days' => $gym_membership_packages,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        DB::table('payments')->insert([
            'order_id' => $params['transaction_details']['order_id'],
            'membership_id' => DB::table('memberships')->latest()->first()->id,
            'user_id' => $user_id,
            'gym_membership_packages' => $request->submit_package_id,
            'amount' => $amount,
            'payment_method' => 'midtrans',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // menambahkan snap token ke table payment
        DB::table('payments')->where('order_id', $params['transaction_details']['order_id'])->update([
            'snap_token' => $snapToken
        ]);

        return view('member.payment.payment_details', compact('snapToken'));
    }

    // public function payment_backup(Request $request)
    // {
    //     $start_date = $request->submit_start_date;
    //     $duration_in_days = DB::table('gym_membership_packages')->where('id', $request->submit_package_id)->pluck('duration_in_days')->first();
    //     $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $duration_in_days . ' days'));
    //     $amount = DB::table('gym_membership_packages')->where('id', $request->submit_package_id)->pluck('price')->first();
    //     $user = DB::table('users')->where('id', $request->submit_user_id)->first();
    //     $params = array(
    //         'transaction_details' => array(
    //             'order_id' => rand(),
    //             'gross_amount' => $amount,
    //         ),
    //         'customer_details' => array(
    //             'name' => $user->name,
    //             'email' => $user->email,
    //             'phone' => $user->phone_number,
    //         ),
    //     );

    //     DB::table('memberships')->insert([
    //         'user_id' => $request->submit_user_id,
    //         'gym_membership_packages' => $request->submit_package_id,
    //         'start_date' => date('Y-m-d'),
    //         'end_date' => $end_date,
    //         'duration_in_days' => $duration_in_days,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     DB::table('payments')->insert([
    //         'order_id' => $params['transaction_details']['order_id'],
    //         'membership_id' => DB::table('memberships')->latest()->first()->id,
    //         'user_id' => $request->submit_user_id,
    //         'gym_membership_packages' => $request->submit_package_id,
    //         'amount' => $amount,
    //         'payment_method' => 'midtrans',
    //         'status' => 'pending',
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     // get current available_personal_trainer in table users
    //     $available_personal_trainer_quota = DB::table('users')->where('id', $request->submit_user_id)->pluck('available_personal_trainer_quota')->first();
    //     $personal_trainer_kouta = DB::table('gym_membership_packages')->where('id', $request->submit_package_id)->pluck('personal_trainer_quota')->first();

    //     // update available_personal_trainer pada table users
    //     DB::table('users')->where('id', $request->submit_user_id)->update([
    //         'available_personal_trainer_quota' => $available_personal_trainer_quota + $personal_trainer_kouta
    //     ]);


    //     $snapToken = \Midtrans\Snap::getSnapToken($params);

    //     // menambahkan snap token ke table payment
    //     DB::table('payments')->where('order_id', $params['transaction_details']['order_id'])->update([
    //         'snap_token' => $snapToken
    //     ]);

    //     return view('member.payment.payment_details', compact('snapToken'));
    // }

    public function payment_callback(Request $request)
    {
        try {
            // Log request payload untuk debugging
            Log::info('Request Payload: ', $request->all());

            // Ambil data dari request
            $orderId = $request->input('order_id');
            $data = Payment::where('order_id', $orderId)->first();
            $transaction = $request->input('transaction_status');
            $type = $data->payment_method;
            $fraud = $data->status;

            // Log untuk pengecekan nilai yang diterima

            Log::info('Extracted Notification Data: ', [
                'transaction' => $transaction,
                'payment_type' => $type,
                'order_id' => $orderId,
                'fraud_status' => $fraud
            ]);

            // Verifikasi semua data yang dibutuhkan ada
            if (is_null($transaction) || is_null($type) || is_null($orderId)) {
                Log::error('Null data received from notification: ', [
                    'transaction' => $transaction,
                    'payment_type' => $type,
                    'order_id' => $orderId,
                    'fraud_status' => $fraud
                ]);
                return response()->json(['status' => 'error', 'message' => 'Invalid notification data'], 400);
            }

            // Cari data pembayaran berdasarkan order_id

            // Pastikan data tersedia sebelum proses lebih lanjut
            if (!$data) {
                Log::error('Order not found: ', ['order_id' => $orderId]);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            // Perbarui status pembayaran
            if ($transaction == 'settlement') {
                $membership = \App\Models\Membership::find($data->membership_id);
                $data->status = 'paid';
                $test_membership = DB::table('memberships')->where('id', $data->membership_id)->update(['is_active' => 1]);

                // disini buat nambah personal trainer quota (gw nambah ini) yang ini beb
                // $personal_trainer_quota_user = DB::table('users')->where('id', $membership->user_id)->pluck('available_personal_trainer_quota')->first();
                $get_package_id_from_membership = DB::table('memberships')->where('id', $data->membership_id)->pluck('gym_membership_packages')->first();
                $personal_trainer_quota_package = DB::table('gym_membership_packages')->where('id', $get_package_id_from_membership)->pluck('personal_trainer_quota')->first();
                // $total_personal_trainer_quota = $personal_trainer_quota_user + $personal_trainer_quota_package;


                DB::table('users')->where('id', $data->user_id)->update([
                    'end_date' => $membership->end_date,
                    'available_personal_trainer_quota' => $personal_trainer_quota_package
                ]);

                // update user terkait dari table membership, update di table user
                $user_terkait = DB::table('memberships')->where('id', $data->membership_id)->pluck('user_terkait')->first();
                // if user terkait tidak 1 user
                if (strpos($user_terkait, ',') !== false) {
                    $user_terkait = explode(',', $user_terkait);
                    foreach ($user_terkait as $key => $value) {
                        // $personal_trainer_quota_user = DB::table('users')->where('id', $value)->pluck('available_personal_trainer_quota')->first();
                        // $total_personal_trainer_quota = $personal_trainer_quota_user + $personal_trainer_quota_package;
                        DB::table('users')->where('id', $value)->update([
                            'end_date' => $membership->end_date,
                            'available_personal_trainer_quota' => $personal_trainer_quota_package
                        ]);
                    }
                    //end

                    $check_extend = DB::table('memberships')->where('user_id', $membership->user_id)->where('is_active', 1)->pluck('id')->toArray();
                    if (count($check_extend) >= 1) {
                        // update latest membership is_active to 1 where user_id = membership user_id
                        DB::table('memberships')->where('id', end($check_extend))->update([
                            'is_active' => 1
                        ]);
                        // change another membership is_active to 0 where user_id = membership user_id
                        $test_user_update_end_date = DB::table('memberships')->where('id', '!=', end($check_extend))->where('user_id', $membership->user_id)->update([
                            'is_active' => 0
                        ]);
                        // update user end_date (gw nambah ini)
                        DB::table('users')->where('id', $membership->user_id)->update([
                            'end_date' => DB::table('memberships')->where('id', end($check_extend))->pluck('end_date')->first()
                        ]);
                        // end
                    }
                } elseif ($transaction == 'cancel' || $transaction == 'deny') {
                    $data->status = 'failed';
                } elseif ($transaction == 'pending') {
                    $data->status = 'pending';
                } elseif ($transaction == 'expire') {
                    $data->status = 'expired';
                }
            }


            $data->save();

            // update status membership
            // $membership = DB::table('memberships')->where('id', $data->membership_id)->first();
            // $user_terkait = DB::table('users')->where('id', $membership->user_id)->pluck('user_terkait')->toArray();
            // if ($transaction == 'settlement') {
            // DB::table('memberships')->where('id', $data->membership_id)->update([
            // where user_id contain in user terkait, where end date same with membership end date
            // DB::table('memberships')->whereIn('user_id', $user_terkait)->where('end_date', $membership->end_date)->update([
            // 'is_active' => 1
            // ]);
            // DB::table('users')->whereIn('id', $user_terkait)->update([
            //  'end_date' => $membership->end_date
            // ]);
            // } elseif ($transaction == 'cancel' || $transaction == 'deny') {
            // DB::table('memberships')->where('id', $data->membership_id)->update([
            //     DB::table('memberships')->whereIn('user_id', $user_terkait)->where('end_date', $membership->end_date)->update([
            //        'is_active' => 0
            //     ]);
            //  } elseif ($transaction == 'pending') {
            // DB::table('memberships')->where('id', $data->membership_id)->update([
            //     DB::table('memberships')->whereIn('user_id', $user_terkait)->where('end_date', $membership->end_date)->update([
            //         'is_active' => 0
            //    ]);
            //   } elseif ($transaction == 'expire') {
            // DB::table('memberships')->where('id', $data->membership_id)->update([
            //    DB::table('memberships')->whereIn('user_id', $user_terkait)->where('end_date', $membership->end_date)->update([
            //      'is_active' => 0
            //    ]);
            //  }

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
            // Mengecek status transaksi
            $payment = Payment::where('order_id', $orderId)->first();
            if (!$payment) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order ID not found.'
                ]);
            }

            $transactionStatus = Payment::where('order_id', $orderId)->first();

            if ($transactionStatus->status === 'pending') {
                return response()->json([
                    'status' => 'pending',
                    'token' => $payment->snap_token
                ]);
            } else {
                // Perbarui status pembayaran
                $payment->status = $transactionStatus->status;
                $payment->save();

                return response()->json([
                    'status' => $transactionStatus->status
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
