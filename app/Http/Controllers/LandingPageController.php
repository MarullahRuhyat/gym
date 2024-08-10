<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function post_question(Request $request)
    {
        $curl = curl_init();
        $token = "SujEXjKi5MEvVWebuRK17sG4H69mKzZwFD4Uca7HPrPwNiQawGLJ4ShA5uCCaUtv";
        $data = [
            'phone' => '6285172014124',
            'message' => 'Nama: ' . $request->name . "\n" . 
                         'Nomor Telpon Penanya: ' . $request->phone . "\n" . 
                         'Pertanyaan: ' . $request->comments
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        return redirect()->back()->with('success', 'Pertanyaan Anda telah terkirim');

    }
}
