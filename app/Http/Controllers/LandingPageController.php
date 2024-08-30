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
        $token = "SujEXjKi5MEvVWebuRK17sG4H69mKzZwFD4Uca7HPrPwNiQawGLJ4ShA5uCCaUtv";

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
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/11325645_1624106467859524_1030807486_a.jpg?stp=dst-jpg_p100x100&_nc_cat=100&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=R_pGLQpn-_UQ7kNvgHdOaSM&_nc_ht=scontent.cdninstagram.com&oh=00_AYCpaItW7T-5PyoZ24lwVWFz_VQ6o9yZSp-pj2ExEcMOqQ&oe=66C914DF'
            ],
            [
                'text' => 'The best gym di Semarang, yang semua gym family nya passionate abis and gokil',
                'instagram_url' => 'https://www.instagram.com/inaratnawati/',
                'name' => '@inaratnawati',
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/418425787_728909796039544_4360184562163851187_n.jpg?stp=dst-jpg_p100x100&_nc_cat=100&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=7nG-qg6uZnoQ7kNvgEcVTwZ&_nc_ht=scontent.cdninstagram.com&oh=00_AYAGfI8ZiE-EQHtW1nNN9kaKNN8pStNMoP7_fWVJrWgVfw&oe=66C91A33'
            ],
            [
                'text' => 'Salah satu tempat gym terbaik di Semarang dengan fasilitas yang baik dan para trainer yang berpengalaman',
                'instagram_url' => 'https://www.instagram.com/agoe4g/',
                'name' => '@agoe4g',
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/121936419_123072619334900_3865311220625362189_n.jpg?stp=dst-jpg_p100x100&_nc_cat=108&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=F8U8Tab3c0YQ7kNvgHRmziM&_nc_ht=scontent.cdninstagram.com&oh=00_AYAOLt9CohRQrrGA35QVQSL9kEYQWW0qTlFZfTuBvIdUiA&oe=66C91321'
            ],
            [
                'text' => 'Trainer bagus, ada progress, suasana gym oke👍',
                'instagram_url' => 'https://www.instagram.com/andrew_wicaksono/',
                'name' => '@Andrew_Wicaksono',
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/34212230_379082989254097_4094707376307830784_n.jpg?stp=dst-jpg_p100x100&_nc_cat=104&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=q1L0oj4-TwIQ7kNvgE9lhlK&_nc_ht=scontent.cdninstagram.com&oh=00_AYALytFSwI0-K4NVcLOMPCnk-9xKGgvxtuQ-FWXZCPUe-A&oe=66C90F05'
            ],
            [
                'text' => 'Family Gym yang bersih dan bersih',
                'instagram_url' => 'https://www.instagram.com/Gabriel_panji/',
                'name' => '@Gabriel_panji',
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/18251835_405119039866939_6669140932790583296_a.jpg?stp=dst-jpg_p100x100&_nc_cat=101&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=C0FiRqCzzyEQ7kNvgGKqwTA&_nc_ht=scontent.cdninstagram.com&oh=00_AYC6tLbRU0GtmfqaG_jYclgraBk09HXNQEC3uTV-d518eQ&oe=66C90081'
            ],
            [
                'text' => 'SEMUA TRAINER NYA EDUCATIVE & HUMORIS LIKE MY SECOND HOME SO PASTI NGGA BOSEN !!!',
                'instagram_url' => 'https://www.instagram.com/dianchristanty11/',
                'name' => '@dianchristanty11',
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/435289977_787460829612121_3696532355309649742_n.jpg?stp=dst-jpg_p100x100&_nc_cat=110&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=mkz-CGCigO4Q7kNvgHHfujS&_nc_ht=scontent.cdninstagram.com&oh=00_AYCPFrbAZYut4VL2djMY8xDBx7MKMH2ZRchXydX-BBSRbA&oe=66C8F5C1'
            ],
            [
                'text' => 'Tempat gym yang more than just a gym, its like a family, PT dan owner yang bisa ngemong member, mereka bekerja dengan hati. Program latihan tersusun rapi tiap member, diarahkan oleh ownernya. Gym yang bener" tempat buat gym..ga ada melenceng"nya',
                'instagram_url' => 'https://www.instagram.com/miraoktarinachandra/',
                'name' => '@miraoktarinachandra',
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/122930891_181487730252378_2450866429398605957_n.jpg?stp=dst-jpg_p100x100&_nc_cat=107&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=7wGIdBRmNXUQ7kNvgEPsS0q&_nc_ht=scontent.cdninstagram.com&oh=00_AYAs80uUZM2scl2wcHB-q0Bl7jdL1TyKhJQ4bhS9RePa2w&oe=66C91509'
            ],
            [
                'text' => 'Flozor tempat gym yg membuat saya betah sejak 2020 karena dekat dengan rumah, Personal Trainer yg kompeten, tau kebutuhan saya dan saya tidak pernah cedera. Sakit boyok saya ga pernah kambuh lagi. Strechingnya sebelum latihan itu tidak ada di gym lain. Apalagi kalo leg day, streching nya muantappppp.... hahaha',
                'instagram_url' => 'https://www.instagram.com/yoshita_jael/',
                'name' => '@yoshita_jael',
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/363509067_956084669173905_4742704307242081586_n.jpg?stp=dst-jpg_p100x100&_nc_cat=102&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=3sPZ1y3ukkUQ7kNvgE6dO8X&_nc_ht=scontent.cdninstagram.com&oh=00_AYCYy8Cf7RrYP_PrPPnNecgDeSiqC7dI2pCZftExJtT0yw&oe=66C91A03'
            ],
            [
                'text' => 'Tempat gym nya Flozor nyaman, coachnya profesional dan berpengalaman, nyaman dan enjoy nge gym di Flozor 👍💪',
                'instagram_url' => 'https://www.instagram.com/Iam_susan/',
                'name' => '@Iam_susan',
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/11373998_382327541961478_1635427854_a.jpg?stp=dst-jpg_p100x100&_nc_cat=106&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=fg2DxINxz-wQ7kNvgH0rNIW&_nc_ht=scontent.cdninstagram.com&oh=00_AYAnXwAi-lA4Flj3H3Yx7tc9KK1u_2Ngs8_DFAP0Rc_C4g&oe=66C8F553'
            ],
            [
                'text' => 'Tempat gym yg seperti rumah sendiri.. nyaman dan aman, tidak takut menempatkan barang apapun di Flozor.. pasti aman.. hp ketinggalan aja sudah 2 jam tetap aman ditempatnya..',
                'instagram_url' => 'https://www.instagram.com/ricky_christian/',
                'name' => '@ricky_christian',
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/11934836_1472910759678940_1110794819_a.jpg?stp=dst-jpg_p100x100&_nc_cat=106&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=7nCaGo_6uJ8Q7kNvgG767tA&_nc_ht=scontent.cdninstagram.com&oh=00_AYD1jmLijGkB3EFOPPbhNiXX77BDsjdilz_ySz06phRt8g&oe=66C90CFF'
            ],
            [
                'text' => 'Best Gym in Semarang. Equipment lengkap dan berkualitas, member disini sangat ramah, PTnya luar biasa dan professional. Highly Recommend!',
                'instagram_url' => 'https://www.instagram.com/nicsoebi/',
                'name' => '@nicsoebi',
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/345792823_775530164105008_1140464546894294328_n.jpg?stp=dst-jpg_p100x100&_nc_cat=100&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=XWwLDo554pQQ7kNvgHV7EXK&_nc_ht=scontent.cdninstagram.com&oh=00_AYBlSHKGmmgufk3R5XO0S4OJ87AyT66BLfTy7MClUaS4CA&oe=66C91701'
            ],
            [
                'text' => 'Gym di Flozor’s asik banget, waktunya fleksibel, jadi bisa kapan ajaa. Instruktur nya juga ramah dan informatif. Selama di Flozor udah berhasil turun 17kg, thankyou Flozor!',
                'instagram_url' => 'https://www.instagram.com/angelanindyta/',
                'name' => '@angelanindyta',
                'image' => 'https://scontent.cdninstagram.com/v/t51.2885-19/420977200_7407123035984730_174204920352751249_n.jpg?stp=dst-jpg_p100x100&_nc_cat=111&ccb=1-7&_nc_sid=fcb8ef&_nc_ohc=Qs5e7BqYPZgQ7kNvgEa-E04&_nc_ht=scontent.cdninstagram.com&oh=00_AYDyR7omuA8JYlMrVcOV2bS05VJLeXdz8tJ0d--uPFt5qQ&oe=66C90697'
            ],
        ];



        foreach ($testimonials as &$testimonial) {
            $testimonial['profile_image'] = $this->getInstagramProfilePicture($testimonial['instagram_url'], $testimonial['image']);
        }

        return view('landing_page.index', compact('testimonials'));
    }

    private function getInstagramProfilePicture($url, $defaultImage)
    {
        try {
            $client = new Client();
            $response = $client->request('GET', $url);

            $html = $response->getBody()->getContents();
            $crawler = new Crawler($html);

            // Attempt to extract the profile picture URL from the meta tag 'og:image'
            $ogImage = $crawler->filter('meta[property="og:image"]')->attr('content');

            if ($ogImage) {
                return $ogImage;
            } else {
                return $defaultImage; // Return the provided default image URL
            }
        } catch (\Exception $e) {
            // In case of any errors (e.g., HTTP request fails), return the default image
            return $defaultImage;
        }
    }

}
