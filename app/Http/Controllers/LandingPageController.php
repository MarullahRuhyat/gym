<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class LandingPageController extends Controller
{

    private function checkDeviceStatus($token)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://jogja.wablas.com/api/device/info?token=$token");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);

        $resultArray = json_decode($result, true);
        if ($resultArray['status'] == 'disconnected') {
            return false; // Perangkat tidak terhubung
        }
        return true; // Perangkat terhubung
    }

    public function post_question(Request $request)
    {
        $token = "zX8x2FOfZW203UptysmQsDccJHyQofZyrN6JWRSZc55qK6uBf6S7ZSdLkMq07YFN.afcch63i";

        // Cek status perangkat sebelum mengirim pesan
        if ($this->checkDeviceStatus($token)) {
            // dd($this->checkDeviceStatus($token));

            dd("test"); 
            return redirect()->back()->with('error', 'Perangkat tidak terhubung');
        }

        $curl = curl_init();
        $data = [
            'phone' => '6285184741788',
            'message' => 'Nama: ' . $request->name . "\n" .
                'Nomor Telpon Penanya: ' . $request->phone . "\n" .
                'Pertanyaan: ' . $request->comments
        ];
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://jogja.wablas.com/api/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        return redirect()->back()->with('success', 'Pertanyaan berhasil dikirim');
    }
    public function index()
    {
        $testimonials = [
            [
                'text' => 'Trainernya ok, program latianmya terjadwal, gak ngasal. Hasilnya nyata',
                'instagram_url' => 'https://www.instagram.com/nicolassantoso?igsh=bGJkZnY3cTYycmlh&utm_source=qr',
                'name' => '@Nicolassantoso',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
            [
                'text' => 'The best gym di Semarang, yang semua gym family nya passionate abis and gokil',
                'instagram_url' => 'https://www.instagram.com/inaratnawati/',
                'name' => '@inaratnawati',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
            [
                'text' => 'Salah satu tempat gym terbaik di Semarang dengan fasilitas yang baik dan para trainer yang berpengalaman',
                'instagram_url' => 'https://www.instagram.com/agoe4g/',
                'name' => '@agoe4g',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
            [
                'text' => 'Trainer bagus, ada progress, suasana gym oke👍',
                'instagram_url' => 'https://www.instagram.com/andrew_wicaksono/',
                'name' => '@Andrew_Wicaksono',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
            [
                'text' => 'Family Gym yang bersih dan bersih',
                'instagram_url' => 'https://www.instagram.com/Gabriel_panji/',
                'name' => '@Gabriel_panji',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
            [
                'text' => 'SEMUA TRAINER NYA EDUCATIVE & HUMORIS LIKE MY SECOND HOME SO PASTI NGGA BOSEN !!!',
                'instagram_url' => 'https://www.instagram.com/dianchristanty11/',
                'name' => '@dianchristanty11',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
            [
                'text' => 'Tempat gym yang more than just a gym, its like a family, PT dan owner yang bisa ngemong member, mereka bekerja dengan hati. Program latihan tersusun rapi tiap member, diarahkan oleh ownernya. Gym yang bener" tempat buat gym..ga ada melenceng"nya',
                'instagram_url' => 'https://www.instagram.com/miraoktarinachandra/',
                'name' => '@miraoktarinachandra',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
            [
                'text' => 'Flozor tempat gym yg membuat saya betah sejak 2020 karena dekat dengan rumah, Personal Trainer yg kompeten, tau kebutuhan saya dan saya tidak pernah cedera. Sakit boyok saya ga pernah kambuh lagi. Strechingnya sebelum latihan itu tidak ada di gym lain. Apalagi kalo leg day, streching nya muantappppp.... hahaha',
                'instagram_url' => 'https://www.instagram.com/yoshita_jael/',
                'name' => '@yoshita_jael',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
            [
                'text' => 'Tempat gym nya Flozor nyaman, coachnya profesional dan berpengalaman, nyaman dan enjoy nge gym di Flozor 👍💪',
                'instagram_url' => 'https://www.instagram.com/Iam_susan/',
                'name' => '@Iam_susan',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
            [
                'text' => 'Tempat gym yg seperti rumah sendiri.. nyaman dan aman, tidak takut menempatkan barang apapun di Flozor.. pasti aman.. hp ketinggalan aja sudah 2 jam tetap aman ditempatnya..',
                'instagram_url' => 'https://www.instagram.com/ricky_christian/',
                'name' => '@ricky_christian',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
            [
                'text' => 'Best Gym in Semarang. Equipment lengkap dan berkualitas, member disini sangat ramah, PTnya luar biasa dan professional. Highly Recommend!',
                'instagram_url' => 'https://www.instagram.com/nicsoebi/',
                'name' => '@nicsoebi',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
            [
                'text' => 'Gym di Flozor’s asik banget, waktunya fleksibel, jadi bisa kapan ajaa. Instruktur nya juga ramah dan informatif. Selama di Flozor udah berhasil turun 17kg, thankyou Flozor!',
                'instagram_url' => 'https://www.instagram.com/angelanindyta/',
                'name' => '@angelanindyta',
                'image' => asset('assets/images/avatars/orang_gym_op.webp')
            ],
        ];


        return view('landing_page.index', compact('testimonials'));
    }


}
