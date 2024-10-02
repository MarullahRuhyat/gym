@extends('member.layouts.guest')
@section('title')
starter Page
@endsection
@section('content')
<!--start main wrapper-->
<div class="main-content">
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card">
                <div class="card-header px-4 py-3">
                    <h5 class="mb-1">Account Details</h5>
                    <p class="mb-4">Enter Your Account Details.</p>
                    @if(session('error'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach(session('error') as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="card-body p-4">
                    <form class="row g-3 needs-validation" novalidate
                        action="{{ route('member.register-form.process') }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <label for="bsValidation1" class="form-label">Name</label>
                            <input type="text" class="form-control" id="bsValidation1" name="name" placeholder="Name"
                                required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation2" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="bsValidation2" placeholder="Phone Number"
                                name="phone_number"
                                oninput="this.value = this.value.replace(/\+62/, '0').replace(/[^0-9]/g, '');" required>
                            <div class="invalid-feedback">
                                Please fill a phone number.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation3" class="form-label">Gender</label>
                            <select class="form-select" id="bsValidation3" name="gender" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid gender.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation4" class="form-label">Address</label>
                            <input type="text" class="form-control" id="bsValidation4" name="address"
                                placeholder="Address" required>
                            <div class="invalid-feedback">
                                Please fill address.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation5" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="bsValidation5" name="start_date" required>
                            <div class="invalid-feedback">
                                Please fill your start date.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation6" class="form-label">Password</label>
                            <div class="input-group">
                                <input id="bsValidation6" type="password" class="form-control" name="password" required
                                    autocomplete="new-password">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                                        <i class="bi-eye-slash-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                Please fill your password.
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="bsValidation7" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input id="bsValidation7" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary"
                                        id="toggle-password-confirm">
                                        <i class="bi-eye-slash-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                Confirmation password is required and must be same as password.
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bsValidation14" required>
                                <label class="form-check-label" for="bsValidation14">Agree to terms and
                                    conditions</label>
                                <div class="invalid-feedback">
                                    You must agree before submitting.
                                </div>

                            </div>
                            <button type="button" class="btn btn-link" data-bs-toggle="modal"
                                data-bs-target="#TermAndConditioModal">
                                Term and Condition?
                            </button>
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary px-4">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->

    <div class="modal fade" id="TermAndConditioModal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 bg-primary py-2">
                    <h5 class="modal-title" style="color:white">Term and Condition</h5>
                    <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                        <i class="material-icons-outlined">close</i>
                    </a>
                </div>
                <div class="modal-body">
                    <p style="text-align: center;"><strong><u><span style="font-size:12pt;">Syarat dan Ketentuan
                                    Flozor&rsquo;s Gym</span></u></strong></p>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">&ldquo;Monthly
                                        Membership&rdquo;&nbsp;</span></strong><span style="font-size:12pt;">Merupakan
                                    program gym kami untuk latihan pribadi bulanan. Durasi waktu mengikuti ketentuan
                                    yang
                                    tercantum dalam pembelian paket (Contoh: 1 month membership berlaku hanya untuk 31
                                    hari,
                                    2 months membership berlaku untuk 62 hari, dan seterusnya). Member dapat mengakses
                                    gym
                                    seharian selama jam buka, menggunakan segala fasilitas yang ada di tempat, serta
                                    bertanya pada instruktur yang sedang bertugas. Dilakukan secara offline di kawasan
                                    Flozor&rsquo;s Gym.</span><span style="font-size:12pt;"><br></span><span
                                    style="font-size:12pt;">Waktu dan kapasitas instruktur untuk menjawab pertanyaan
                                    terbatas pada paket monthly membership. Pelatihan secara privat dan intensif oleh
                                    instruktur harus dengan membeli paket PBC/PBBC. Pelatihan secara privat dan intensif
                                    oleh owner harus dengan membeli paket PBC/PBBC Gold.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">Program
                                        &ldquo;PBC&rdquo;&nbsp;</span></strong><span style="font-size:12pt;">Adalah
                                    singkatan dari &ldquo;Personal Body Care&rdquo; yang
                                    merupakan program gym kami untuk para laki-laki. Dilakukan secara offline di kawasan
                                    Flozor&rsquo;s Gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">Program
                                        &ldquo;PBBC&rdquo;&nbsp;</span></strong><span style="font-size:12pt;">Adalah
                                    singkatan dari &ldquo;Personal Beauty Body Care&rdquo;
                                    yang merupakan program gym kami untuk para wanita. Dilakukan secara offline di
                                    kawasan
                                    Flozor&rsquo;s Gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">Program &ldquo;One Day
                                        Pass&rdquo;&nbsp;</span></strong><span style="font-size:12pt;">Merupakan program
                                    gym
                                    kami untuk satu kali datang. Dilakukan di kawasan Flozor&rsquo;s Gym. Member dapat
                                    mengakses gym seharian selama jam buka, menggunakan segala fasilitas yang ada di
                                    tempat,
                                    serta bertanya pada instruktur yang sedang bertugas. Dilakukan secara offline di
                                    kawasan
                                    Flozor&rsquo;s Gym.</span><span style="font-size:12pt;"><br></span><span
                                    style="font-size:12pt;">Waktu dan kapasitas instruktur untuk menjawab pertanyaan
                                    terbatas pada paket one day pass isidentil. Pelatihan secara privat dan intensif
                                    oleh
                                    instruktur harus dengan membeli paket one day pass PBC/PBBC isidentil. Pelatihan
                                    secara
                                    privat dan intensif oleh owner harus dengan membeli paket one day pass PBC/PBBC Gold
                                    Single
                                    isidentil.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">Produk &ldquo;FHF&rdquo;&nbsp;</span></strong><span
                                    style="font-size:12pt;">Adalah singkatan dari &ldquo;Flozor&rsquo;s Healthy
                                    Food&rdquo;
                                    yang merupakan program makanan sehat berupa catering, diperuntukkan untuk segala
                                    kalangan, termasuk non-member dari Flozor&rsquo;s Gym. Tidak tersedia setiap waktu.
                                    Dapat menghubungi WA Official kami di +6285184741788 untuk informasi lebih
                                    lanjut.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">Produk
                                        &ldquo;Floathies&rdquo;&nbsp;</span></strong><span
                                    style="font-size:12pt;">Adalah
                                    singkatan dari &ldquo;Flozor&rsquo;s Smoothies&rdquo; yang merupakan program minuman
                                    sehat berupa green juice, smoothies, dan jus dada ayam, diperuntukkan untuk segala
                                    kalangan, termasuk non-member dari Flozor&rsquo;s Gym. Tidak tersedia setiap waktu.
                                    Dapat menghubungi WA Official kami di +6285184741788 untuk informasi lebih
                                    lanjut.</span></p>
                        </li>
                    </ul>
                    <p style="text-align: center;"><strong><span style="font-size:12pt;">Peraturan Umum</span></strong>
                    </p>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Flozor&rsquo;s Gym melayani member secara offline sesuai
                                    jam
                                    buka, yaitu:</span></p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Hari Senin s.d Jumat pk. 6.00 - 20.00 WIB</span>
                                    </p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Hari Sabtu pk. 6.00 - 18.00 WIB</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Hari Besar pk. 6.00 - 18.00 WIB</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Hari Minggu libur (untuk hari besar tertentu, pihak
                                            Flozor&rsquo;s Gym akan memberi pemberitahuan lebih lanjut bila ada
                                            penutupan
                                            tempat)</span></p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Member wajib melaporkan histori kesehatan yang dimiliki
                                    secara
                                    detail.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Member wajib menggunakan perlengkapan olahraga bila
                                    memasuki
                                    kawasan gym, antara lain:</span></p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">&nbsp;Pakaian Olahraga</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Sepatu</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Handuk (bila diperlukan)</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Sarung tangan (bila diperlukan)</span></p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Member wajib mengembalikan peralatan pada tempat semula
                                    setelah
                                    menggunakan.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Member wajib menjaga kebersihan dengan tidak meninggalkan
                                    sampah dan membuang pada tempatnya.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Semua pembayaran makanan dan minuman yang disediakan di
                                    Flozor&rsquo;s Gym dilakukan di depan kepada resepsionis, dapat menggunakan metode
                                    tunai
                                    ataupun Qris.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Member diharapkan memperhatikan barang bawaan sebelum
                                    meninggalkan kawasan gym, karena pihak Flozor&rsquo;s Gym tidak bertanggungjawab
                                    atas
                                    kehilangan barang berharga dalam bentuk apapun.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Tidak diperkenankan dalam kawasan Flozor&rsquo;s Gym
                                    melakukan
                                    tindakan tidak senonoh, berjudi, melakukan transaksi gelap, atau kegiatan lainnya
                                    yang
                                    tidak sesuai dengan norma atau peraturan yang berlaku.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Tidak diperkenankan merokok di kawasan gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Tidak diperkenankan makan di area pelatihan di kawasan
                                    gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Tidak diperkenankan melakukan transaksi penjualan yang
                                    berhubungan dengan gym (misal: suplemen, makanan diet, atau alat-alat) di dalam
                                    kawasan
                                    gym tanpa seijin Flozor&rsquo;s Gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Tidak diperkenankan membawa PT dari luar untuk latihan di
                                    kawasan Flozor&rsquo;s Gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Pemberian tip kepada instruktur harus melewati pihak
                                    Flozor&rsquo;s Gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Tidak diperkenankan latihan ketika sedang memiliki penyakit
                                    menular di dalam kawasan gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Tidak mengganggu kenyamanan member lain dalam kawasan
                                    gym.&nbsp;</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Harap menggunakan parfum atau deodoran jika merasa memiliki
                                    bau
                                    badan yang dapat mengganggu kenyamanan member lain.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Parkir secara bertanggung jawab. Jangan lupa mengunci
                                    kendaraan
                                    demi keamanan bersama. Pihak Flozor&rsquo;s Gym hanya menyediakan CCTV untuk
                                    pengawasan,
                                    namun tidak bertanggungjawab atas segala kerusakan dan kehilangan kendaraan di area
                                    parkir.&nbsp;</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Melakukan pembayaran di depan, dapat melalui uang tunai,
                                    transfer (mobile banking), debit, atau kredit (terkena charge 2.5%).</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Jika menggunakan fasilitas loker dengan kunci, wajib
                                    meninggalkan kartu identitas (SIM atau KTP), atau barang berharga lain (misal: kunci
                                    motor atau mobil).</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Member wajib untuk login setiap saat latihan pada website
                                    Flozor&rsquo;s Gym di</span><a href="https://flozorsgym.com/"><span
                                        style="font-size:12pt;">&nbsp;</span><u><span
                                            style="color:#1155cc;font-size:12pt;">https://flozorsgym.com/</span></u></a><span
                                    style="font-size:12pt;">&nbsp;menggunakan kode OTP yang dikirimkan melalui nomor
                                    telepon
                                    atau password. QR Code ini digunakan untuk menghitung jumlah sesi pertemuan dan
                                    absensi
                                    secara general. Member wajib membawa HP atau perangkat apapun yang dapat menampilkan
                                    QR
                                    Code pada website Flozor&rsquo;s Gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Status member saat datang ke dalam kawasan Flozor&rsquo;s
                                    Gym
                                    harus aktif. Bila status tidak aktif atau tidak terdaftar pada sistem, maka member
                                    harus
                                    membeli baru/membeli perpanjangan paket pada website</span><a
                                    href="https://flozorsgym.com/"><span style="font-size:12pt;">&nbsp;</span><u><span
                                            style="color:#1155cc;font-size:12pt;">https://flozorsgym.com/</span></u></a><span
                                    style="font-size:12pt;">. Semua pertanyaan online dapat diajukan melalui WA Official
                                    kami di +6285184741788.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Pembelian atau perpanjangan paket hanya dapat dilakukan
                                    melalui
                                    website</span><a href="https://flozorsgym.com/"><span
                                        style="font-size:12pt;">&nbsp;</span><u><span
                                            style="color:#1155cc;font-size:12pt;">https://flozorsgym.com/</span></u></a><span
                                    style="font-size:12pt;">. Pembayaran yang dilakukan di luar website harus
                                    mendapatkan
                                    konfirmasi dari owner/admin WA Official kami di +6285184741788. Jika tidak, maka
                                    pihak
                                    Flozor&rsquo;s Gym tidak bertanggungjawab atas kerugian atau tindak penipuan yang
                                    terjadi pada member.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Jika member sudah melewati masa tenggang, baik dalam jenis
                                    paket apapun, status akan otomatis inaktif dan tidak dapat mengakses fasilitas
                                    Flozor&rsquo;s Gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Perpanjangan paket monthly membership hanya dapat dilakukan
                                    per
                                    bulan (31 hari) dan jumlah total hari akan otomatis ditambahkan tanpa menghanguskan
                                    paket sebelumnya. Jika member ingin membeli paket perpanjangan lebih dari 31 hari,
                                    maka
                                    harus membeli paket baru (misalnya paket 3 months membership), namun akan
                                    menghanguskan
                                    sisa hari dari paket sebelumnya.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Perpindahan paket yang berbeda jenis juga akan
                                    menghanguskan
                                    paket sebelumnya ketika sudah melakukan pembayaran.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Segala promo dan diskon paket maupun produk mengikuti
                                    informasi
                                    dengan ketentuan seperti apa yang ada pada website</span><a
                                    href="https://flozorsgym.com/"><span style="font-size:12pt;">&nbsp;</span><u><span
                                            style="color:#1155cc;font-size:12pt;">https://flozorsgym.com/</span></u></a><span
                                    style="font-size:12pt;">&nbsp;dan/atau WA Official kami di +6285184741788.</span>
                            </p>
                        </li>
                    </ul>
                    <p style="text-align: center;"><strong><span style="font-size:12pt;">Pelanggaran</span></strong></p>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Member atau non-member yang melanggar peraturan yang telah
                                    ditetapkan akan mendapat peringatan maksimal dua kali. Jika masih melanggar, maka
                                    member
                                    akan mendapat sanksi sesuai dengan peraturan yang dilanggar. Sanksi dapat
                                    berupa:</span>
                            </p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Denda (owner akan menentukan jumlah besar denda
                                            sesuai
                                            dengan ketentuan yang dilanggar setelah peringatan 2x).</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Dispensasi (dalam jangka waktu tertentu member
                                            tidak
                                            diperbolehkan beraktivitas di kawasan Flozor&rsquo;s Gym).</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Pencabutan hak member atau non-member untuk
                                            beraktivitas di kawasan Flozor&rsquo;s Gym ataupun mengikuti program apapun
                                            dari
                                            Flozor&rsquo;s Gym).</span></p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <p style="text-align: center;"><span style="font-size:12pt;">Yang tidak tercantum secara tertulis,
                            tergantung dengan situasi dan kondisi, akan disampaikan secara lisan maupun tertulis oleh
                            pihak
                            manajemen kami melalui WA Official kami di +6285184741788.</span></p>
                    <p><br></p>
                    <p style="text-align: center;"><strong><span style="font-size:12pt;">PBC/PBBC dan PBC/PBBC
                                Gold</span></strong></p>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Fasilitas yang didapatkan member antara lain adalah:</span>
                            </p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Member dapat menggunakan semua alat fitness yang
                                            terdapat di kawasan Flozor&rsquo;s Gym.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Member mendapat fasilitas tempat penyimpanan barang
                                            (loker beserta kunci), dan fasilitas kamar mandi terpisah, di dalam kawasan
                                            gym.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Member sudah tidak perlu membayar iuran pelatihan
                                            membership.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Instruktur (Untuk Gold: Owner) akan mendampingi
                                            member
                                            selama latihan dari awal sampai akhir (durasi kurang lebih 1 jam).</span>
                                    </p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Instruktur (Untuk Gold: Instruktur dan Owner)
                                            melayani
                                            semua pertanyaan yang ada, yang berkaitan dengan aktivitas gym, kesehatan,
                                            ataupun nutrisi secara langsung, baik secara online maupun offline. Semua
                                            pertanyaan online dapat diajukan melalui WA Official kami di
                                            +6285184741788.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Instruktur mencatat proses perkembangan member
                                            setiap 3
                                            bulan secara detail, dan member berhak meminta informasi perkembangan
                                            tersebut
                                            kepada instruktur ketika diperlukan.</span></p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Member wajib untuk scan salah satu dari QR di bawah ini
                                    dalam
                                    kondisi:</span></p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">QR Code PT: Ketika sudah membuat janji latihan
                                            dengan
                                            instruktur/owner. Scanning dilakukan 2x, saat datang dan pulang, guna untuk
                                            menghitung jumlah sesi pertemuan, dan lamanya sesi pertemuan berlangsung.
                                            Scan
                                            QR dapat diwakilkan oleh satu orang saja untuk paket couple, group, dan
                                            class.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">QR Code Absensi: Ketika member datang untuk latihan
                                            sendiri. Scanning dilakukan 2x, saat datang dan pulang, guna untuk mendata
                                            absensi harian member. Scan QR tetap berjalan secara masing-masing, dan
                                            tidak
                                            diwakilkan ketika datang latihan secara terpisah maupun bersamaan.</span>
                                    </p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Untuk paket PBC/PBBC/PBC Gold/PBBC Gold Single dan Couple,
                                    pertemuan diselesaikan dalam waktu 12 kali dengan tenggang 45 hari. Jika pertemuan
                                    belum
                                    selesai namun sudah melebihi tenggang, dianggap hangus. Diberi kesempatan
                                    memperpanjang
                                    paket bulanan selama 31 hari sebesar 325.000 maksimal 2x jika masih ada tersisa
                                    pertemuan setelah 45 hari.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Untuk paket PBC/PBBC Group dan Class, serta PBC/PBBC Gold
                                    Group, pertemuan diselesaikan dalam waktu 10 kali dengan tenggang 31 hari. Jika
                                    pertemuan belum selesai namun sudah melebihi tenggang, dianggap hangus. Diberi
                                    kesempatan memperpanjang paket bulanan selama 31 hari sebesar 325.000 maksimal 2x
                                    jika
                                    masih ada tersisa pertemuan setelah 45 hari.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Pembatalan jadwal oleh member, maksimal diberitahukan
                                    sehari
                                    sebelum (1x24 jam). Jika tidak, maka member dianggap tetap hadir (terhitung 1x
                                    pertemuan).</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Pembatalan jadwal oleh instruktur, maksimal diberitahukan
                                    sehari sebelum (1x24 jam) dan akan ada jadwal pengganti, sesuai yang telah
                                    disepakati
                                    kedua belah pihak.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Setiap program berlaku hanya untuk nama orang yang
                                    terdaftar
                                    pada sistem, tidak dapat digantikan oleh orang lain.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Bila member dari awal sudah memilih bentuk pelatihan
                                    couple,
                                    group, atau class, dan satu atau lebih member tidak hadir pada waktu jam latihan
                                    yang
                                    telah disepakati, pertemuan akan tetap dilaksanakan (terhitung 1x pertemuan untuk
                                    setiap
                                    orang). Kecuali bila pembatalan dilakukan oleh semua member yang ada di dalam group,
                                    sesuai dengan ketentuan pembatalan jadwal di atas.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Jam latihan member adalah jam yang telah disepakati oleh
                                    member
                                    dan instruktur/owner. Bila ada keterlambatan, tidak ada penambahan waktu dari pihak
                                    Flozor&rsquo;s Gym. Namun jika keterlambatan tersebut dari pihak Flozor&rsquo;s Gym,
                                    waktu latihan akan diganti sesuai dengan keterlambatan instruktur/owner.</span></p>
                        </li>
                    </ul>
                    <p style="text-align: center;"><strong><span style="font-size:12pt;">Monthly
                                Membership</span></strong>
                    </p>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Fasilitas yang didapatkan member antara lain adalah:</span>
                            </p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Member dapat menggunakan semua alat fitness yang
                                            terdapat di kawasan Flozor&rsquo;s Gym.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Member mendapat fasilitas tempat penyimpanan barang
                                            (loker beserta kunci), dan fasilitas kamar mandi terpisah, di dalam kawasan
                                            gym.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Member dapat menanyai instruktur yang jaga shift
                                            pagi
                                            dan malam, namun kapasitas mereka terbatas, dan akan lebih memprioritaskan
                                            yang
                                            mengambil paket PBC/PBBC/PBC Gold/PBBC Gold.</span></p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Pertemuan diselesaikan dalam waktu yang telah disepakati
                                    sesuai
                                    durasi waktu paket yang dibeli, yaitu:</span></p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">1 month: masa berlaku 31 hari terhitung sejak
                                            tanggal
                                            mulai latihan.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">2 months: masa berlaku 62 hari terhitung sejak
                                            tanggal
                                            mulai latihan.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">3 months: masa berlaku 93 hari terhitung sejak
                                            tanggal
                                            mulai latihan.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">6 months: masa berlaku 186 hari terhitung sejak
                                            tanggal
                                            mulai latihan.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">1 year: masa berlaku 372 hari terhitung sejak
                                            tanggal
                                            mulai latihan.</span></p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Member wajib untuk scan QR Code Absensi ketika member
                                    datang
                                    untuk latihan sendiri. Scanning dilakukan 2x, saat datang dan pulang, guna untuk
                                    mendata
                                    absensi harian member.</span></p>
                        </li>
                    </ul>
                    <p style="text-align: center;"><strong><span style="font-size:12pt;">One Day Pass</span></strong>
                    </p>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Fasilitas yang didapatkan member antara lain adalah:</span>
                            </p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Member dapat menggunakan semua alat fitness yang
                                            terdapat di kawasan Flozor&rsquo;s Gym dalam jangka waktu satu hari itu
                                            (bebas
                                            berapa kali datang), sesuai jam buka gym.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Member mendapat fasilitas tempat penyimpanan barang
                                            (loker beserta kunci), dan fasilitas kamar mandi terpisah, di dalam kawasan
                                            gym,
                                            secara offline.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Member dapat menanyai instruktur yang jaga shift
                                            pagi
                                            dan malam, namun kapasitas mereka terbatas, dan akan lebih memprioritaskan
                                            yang
                                            mengambil paket PBC/PBBC/PBC Gold/PBBC Gold.</span></p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <p><br></p>
                    <p><br></p>
                    <p><br></p>
                    <p><br></p>
                    <p><br></p>
                    <p><br></p>
                    <p><br></p>
                    <h3 style="text-align: center;"><strong><span style="font-size:13pt;">Flozor&rsquo;s Gym Terms and
                                Conditions</span></strong></h3>
                    <h4 style="text-align: center;"><strong><span style="font-size:11pt;">Definitions</span></strong>
                    </h4>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:11pt;">&quot;Monthly Membership&quot;</span></strong><span
                                    style="font-size:12pt;">&nbsp;Refers to our gym program for monthly personal
                                    training.
                                    The duration matches the terms specified in the purchased package (e.g., 1-month
                                    membership is valid for 31 days, 2-months membership is valid for 62 days, and so
                                    on).
                                    Members can access the gym all day during opening hours, use all available
                                    facilities,
                                    and ask the on-duty instructor questions. Training is conducted offline at
                                    Flozor&rsquo;s Gym. Instructor availability for answering questions is limited to
                                    the
                                    monthly membership package. Intensive private training by an instructor requires
                                    purchasing the PBC/PBBC package. Intensive private training by the owner requires
                                    purchasing the PBC/PBBC Gold package.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">&quot;PBC&quot; Program</span></strong><span
                                    style="font-size:12pt;">&nbsp;Stands for &quot;Personal Body Care,&quot; which is
                                    our
                                    gym program for men. Training is conducted offline at Flozor&rsquo;s Gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">&quot;PBBC&quot; Program</span></strong><span
                                    style="font-size:12pt;">&nbsp;Stands for &quot;Personal Beauty Body Care,&quot;
                                    which is
                                    our gym program for women. Training is conducted offline at Flozor&rsquo;s
                                    Gym.</span>
                            </p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">&quot;One Day Pass&quot;</span></strong><span
                                    style="font-size:12pt;">&nbsp;Refers to our gym program for a one-time visit.
                                    Training
                                    is conducted offline at Flozor&rsquo;s Gym. Members can access the gym all day
                                    during
                                    opening hours, use all available facilities, and ask the on-duty instructor
                                    questions.
                                    Instructor availability for answering questions is limited for the one-day pass.
                                    Intensive private training by an instructor requires purchasing the One Day Pass
                                    PBC/PBBC. Intensive private training by the owner requires purchasing the One Day
                                    Pass
                                    PBC/PBBC Gold.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">&quot;FHF&quot; Product</span></strong><span
                                    style="font-size:12pt;">&nbsp;Stands for &quot;Flozor&rsquo;s Healthy Food,&quot;
                                    which
                                    is our healthy catering program available to all, including non-members of
                                    Flozor&rsquo;s Gym. Not available at all times; for more information, contact our
                                    Official WA at +6285184741788.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">&quot;Floathies&quot; Product</span></strong><span
                                    style="font-size:12pt;">&nbsp;Stands for &quot;Flozor&rsquo;s Smoothies,&quot; which
                                    is
                                    our healthy drink program including green juice, smoothies, and chicken breast
                                    juice,
                                    available to all, including non-members of Flozor&rsquo;s Gym. Not available at all
                                    times; for more information, contact our Official WA at +6285184741788.</span></p>
                        </li>
                    </ul>
                    <h4 style="text-align: center;"><strong><span style="font-size:11pt;">General Rules</span></strong>
                    </h4>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Flozor&rsquo;s Gym serves members offline according to the
                                    opening hours:&nbsp;</span></p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Monday to Friday 6:00 AM - 8:00 PM WIB&nbsp;</span>
                                    </p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Saturday 6:00 AM - 6:00 PM WIB&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Public Holidays 6:00 AM - 6:00 PM WIB&nbsp;</span>
                                    </p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Sunday closed (for specific public holidays,
                                            Flozor&rsquo;s Gym will provide further notification if there is a
                                            closure)</span></p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Members are required to report their health history in
                                    detail.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Members must wear sports attire when entering the gym,
                                    including:&nbsp;</span></p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Sportswear&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Shoes&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Towel (if needed)&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Gloves (if needed)</span></p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Members must return equipment to its original place after
                                    use.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Members must maintain cleanliness by not leaving trash and
                                    disposing of it properly.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">All food and drink payments at Flozor&rsquo;s Gym are made
                                    at
                                    the reception desk, using either cash or QRIS.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Members should check their belongings before leaving the
                                    gym,
                                    as Flozor&rsquo;s Gym is not responsible for the loss of valuable items in any
                                    form.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">No inappropriate actions, gambling, illegal transactions,
                                    or
                                    activities against norms or regulations are allowed within Flozor&rsquo;s
                                    Gym.</span>
                            </p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Smoking is prohibited in the gym area.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Eating is prohibited in the training area of the
                                    gym.</span>
                            </p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">No sales transactions related to the gym (e.g.,
                                    supplements,
                                    diet foods, or equipment) are allowed inside the gym without permission from
                                    Flozor&rsquo;s Gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">External personal trainers cannot be brought in for
                                    training
                                    within Flozor&rsquo;s Gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Tips to instructors must go through Flozor&rsquo;s
                                    Gym.</span>
                            </p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Training is not allowed when having contagious diseases in
                                    the
                                    gym.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Do not disturb the comfort of other members in the
                                    gym.</span>
                            </p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Please use perfume or deodorant if you feel that you have
                                    body
                                    odor that might affect the comfort of others.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Park responsibly. Don&rsquo;t forget to lock your vehicle
                                    for
                                    mutual security. Flozor&rsquo;s Gym only provides CCTV for monitoring and is not
                                    responsible for any damage or loss of vehicles in the parking area.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Payments are made in advance and can be made through cash,
                                    transfer (mobile banking), debit, or credit card (subject to a 2.5% charge).</span>
                            </p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">If using a locker with a key, members must leave an
                                    identity
                                    card (e.g., driver&rsquo;s license or ID card) or other valuable items (e.g.,
                                    motorbike
                                    or car keys).</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Members must log in every time they train on the
                                    Flozor&rsquo;s
                                    Gym website at</span><a href="https://flozorsgym.com/"><span
                                        style="font-size:12pt;">&nbsp;</span><u><span
                                            style="color:#1155cc;font-size:12pt;">https://flozorsgym.com/</span></u></a><span
                                    style="font-size:12pt;">&nbsp;using the OTP code sent to their phone number or
                                    password.
                                    This QR Code is used to track session counts and general attendance. Members must
                                    bring
                                    a mobile phone or device that can display the QR Code on the Flozor&rsquo;s Gym
                                    website.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Member status upon entering Flozor&rsquo;s Gym must be
                                    active;
                                    if status is inactive or not registered in the system, the member must purchase a
                                    new or
                                    extended package on the website</span><a href="https://flozorsgym.com/"><span
                                        style="font-size:12pt;">&nbsp;</span><u><span
                                            style="color:#1155cc;font-size:12pt;">https://flozorsgym.com/</span></u></a><span
                                    style="font-size:12pt;">. All online inquiries can be made via our Official WA at
                                    +6285184741788.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Package purchases or extensions can only be made through
                                    the
                                    website</span><a href="https://flozorsgym.com/"><span
                                        style="font-size:12pt;">&nbsp;</span><u><span
                                            style="color:#1155cc;font-size:12pt;">https://flozorsgym.com/</span></u></a><span
                                    style="font-size:12pt;">. Payments made outside the website must be confirmed by the
                                    owner/admin via our Official WA at +6285184741788. If not, Flozor&rsquo;s Gym is not
                                    responsible for losses or fraud.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">If a member exceeds the grace period, regardless of the
                                    package
                                    type, the status will automatically become inactive, and the member will not be able
                                    to
                                    access Flozor&rsquo;s Gym facilities.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Extension of the monthly membership package can only be
                                    done
                                    monthly (31 days), and the total number of days will be automatically added without
                                    invalidating the previous package. If a member wants to purchase an extension
                                    package
                                    longer than 31 days, they must purchase a new package (e.g., a 3-month membership),
                                    which will invalidate the remaining days of the previous package.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Changing to a different type of package will also
                                    invalidate
                                    the previous package once payment is made.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">All promotions and discounts on packages or products follow
                                    the
                                    information and terms provided on the website</span><a
                                    href="https://flozorsgym.com/"><span style="font-size:12pt;">&nbsp;</span><u><span
                                            style="color:#1155cc;font-size:12pt;">https://flozorsgym.com/</span></u></a><span
                                    style="font-size:12pt;">&nbsp;and/or our Official WA at +6285184741788.</span></p>
                        </li>
                    </ul>
                    <p style="text-align: center;"><strong><span style="font-size:12pt;">Violations</span></strong></p>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Members or non-members who violate the established rules
                                    will
                                    receive a maximum of two warnings. If violations persist, sanctions will be applied
                                    based on the rule breached. Sanctions may include:</span></p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Fines (the owner will determine the fine amount
                                            based
                                            on the rule violated after two warnings).&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Suspension (members are prohibited from activities
                                            at
                                            Flozor&rsquo;s Gym for a certain period).&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Revocation of the right to access Flozor&rsquo;s
                                            Gym
                                            facilities or participate in any Flozor&rsquo;s Gym programs.</span></p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <p style="text-align: center;"><span style="font-size:12pt;">Any matters not explicitly covered in
                            writing will be communicated verbally or in writing by our management through our Official
                            WA at
                            +6285184741788.</span></p>
                    <p><br></p>
                    <h4 style="text-align: center;"><strong><span style="font-size:11pt;">PBC/PBBC and PBC/PBBC
                                Gold</span></strong></h4>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Facilities included for members:&nbsp;</span></p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Members can use all fitness equipment available at
                                            Flozor&rsquo;s Gym.&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Members receive storage facilities (lockers with
                                            keys),
                                            and separate bathroom facilities within the gym.&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Members do not need to pay membership training
                                            fees.&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Instructors (For Gold: Owner) will accompany
                                            members
                                            during training from start to finish (approximately 1 hour).&nbsp;</span>
                                    </p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Instructors (For Gold: Instructor and Owner) will
                                            answer all questions related to gym activities, health, or nutrition both
                                            online
                                            and offline. All online questions can be submitted via our Official WA at
                                            +6285184741788.&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Instructors will record member progress every 3
                                            months
                                            in detail, and members have the right to request this progress information
                                            from
                                            the instructor when needed.</span></p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Members must scan one of the QR Codes below under these
                                    conditions:</span></p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">&nbsp;QR Code PT: When making a training
                                            appointment
                                            with an instructor/owner. Scanning is done twice, upon arrival and
                                            departure, to
                                            track the number of sessions and duration. Scanning can be represented by
                                            one
                                            person for couple, group, and class packages.&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">QR Code Attendance: When members come for solo
                                            training. Scanning is done twice, upon arrival and departure, to record
                                            daily
                                            attendance. QR scanning remains individual and cannot be represented when
                                            coming
                                            for separate or simultaneous training sessions.</span></p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">For PBC/PBBC/PBC Gold/PBBC Gold Single and Couple packages,
                                    meetings must be completed within 12 sessions with a 45-day grace period. If
                                    meetings
                                    are not completed but exceed the grace period, they are considered forfeited. There
                                    is
                                    an opportunity to extend the monthly package for 31 days at a cost of 325,000 IDR,
                                    up to
                                    2 times if there are remaining sessions after 45 days.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">For PBC/PBBC Group and Class, and PBC/PBBC Gold Group
                                    packages,
                                    meetings must be completed within 10 sessions with a 31-day grace period. If
                                    meetings
                                    are not completed but exceed the grace period, they are considered forfeited. There
                                    is
                                    an opportunity to extend the monthly package for 31 days at a cost of 325,000 IDR,
                                    up to
                                    2 times if there are remaining sessions after 45 days.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Cancellations by members must be notified at least one day
                                    in
                                    advance (1x24 hours); otherwise, the member is considered present (counted as 1
                                    session).</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Cancellations by instructors must be notified at least one
                                    day
                                    in advance (1x24 hours), and a replacement schedule will be provided, as agreed upon
                                    by
                                    both parties.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Each program is valid only for the registered
                                    individual&apos;s
                                    name and cannot be substituted by another person.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">If a member initially chooses couple, group, or class
                                    training
                                    and one or more members do not attend at the agreed training time, the meeting will
                                    still be held (counted as 1 session for each person). Except when all members in the
                                    group cancel, according to the cancellation rules above.</span></p>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Training times are the times agreed upon between members
                                    and
                                    instructors/owners. If there is a delay, there will be no additional time provided
                                    by
                                    Flozor&rsquo;s Gym. However, if the delay is from Flozor&rsquo;s Gym, the training
                                    time
                                    will be adjusted according to the instructor/owner&rsquo;s delay.</span></p>
                        </li>
                    </ul>
                    <h4 style="text-align: center;"><strong><span style="font-size:11pt;">Monthly
                                Membership</span></strong>
                    </h4>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">Facilities included for
                                        members:</span></strong><span style="font-size:12pt;">&nbsp;</span></p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Members can use all fitness equipment available at
                                            Flozor&rsquo;s Gym.&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Members receive storage facilities (lockers with
                                            keys),
                                            and separate bathroom facilities within the gym.&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Members can ask questions to the instructors on
                                            morning
                                            and evening shifts, though their capacity is limited and will prioritize
                                            those
                                            with PBC/PBBC/PBC Gold/PBBC Gold packages.</span></p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">Duration and validity of
                                        memberships:</span></strong>
                            </p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">1 month: valid for 31 days from the start
                                            date.</span>
                                    </p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">2 months: valid for 62 days from the start
                                            date.</span>
                                    </p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">3 months: valid for 93 days from the start
                                            date.</span>
                                    </p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">6 months: valid for 186 days from the start
                                            date.</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">1 year: valid for 372 days from the start
                                            date.</span>
                                    </p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Members must scan the QR Code Attendance when coming for
                                    solo
                                    training. Scanning is done twice, upon arrival and departure, to record daily
                                    attendance.</span></p>
                        </li>
                    </ul>
                    <p><strong><span style="font-size:12pt;">One Day Pass</span></strong></p>
                    <ul>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><strong><span style="font-size:12pt;">Facilities included for
                                        members:</span></strong><span style="font-size:12pt;">&nbsp;</span></p>
                            <ul>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Members can use all fitness equipment available at
                                            Flozor&rsquo;s Gym for one day (unlimited visits within the day), according
                                            to
                                            gym opening hours.&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Members receive storage facilities (lockers with
                                            keys),
                                            and separate bathroom facilities within the gym, offline.&nbsp;</span></p>
                                </li>
                                <li style="list-style-type:circle;font-size:12pt;">
                                    <p><span style="font-size:12pt;">Members can ask questions to instructors on morning
                                            and
                                            evening shifts, though their capacity is limited and will prioritize those
                                            with
                                            PBC/PBBC/PBC Gold/PBBC Gold packages.</span></p>
                                </li>
                            </ul>
                        </li>
                        <li style="list-style-type:disc;font-size:12pt;">
                            <p><span style="font-size:12pt;">Members must scan the QR Code Attendance when coming for
                                    solo
                                    training. Scanning is done twice, upon arrival and departure, to record
                                    attendance.</span></p>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<!-- validate  -->
<script src="{{ URL::asset('build/plugins/validation/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/validation/validation-script.js') }}"></script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()

    // check password and confirm password
    $(document).ready(function () {
        $('#bsValidation6').keyup(function () {
            var password = $('#bsValidation6').val();
            var confirmPassword = $('#bsValidation7').val();
            if (password != confirmPassword) {
                $('#bsValidation7').addClass('is-invalid');
                $('#bsValidation7').removeClass('is-valid');
            } else {
                $('#bsValidation7').addClass('is-valid');
                $('#bsValidation7').removeClass('is-invalid ');
            }
        });

        $('#bsValidation7').keyup(function () {
            var password = $('#bsValidation6').val();
            var confirmPassword = $('#bsValidation7').val();
            if (password != confirmPassword) {
                $('#bsValidation7').addClass('is-invalid');
                $('#bsValidation7').removeClass('is-valid');
            } else {
                $('#bsValidation7').addClass('is-valid');
                $('#bsValidation7').removeClass('is-invalid');
            }
        });
    });

    document.getElementById('toggle-password').addEventListener('click', function () {
        var passwordInput = document.getElementById('bsValidation6');
        var passwordIcon = this.querySelector('i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('bi-eye-slash-fill');
            passwordIcon.classList.add('bi-eye-fill');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('bi-eye-fill');
            passwordIcon.classList.add('bi-eye-slash-fill');
        }
    });

    document.getElementById('toggle-password-confirm').addEventListener('click', function () {
        var confirmPasswordInput = document.getElementById('bsValidation7');
        var confirmPasswordIcon = this.querySelector('i');
        if (confirmPasswordInput.type === 'password') {
            confirmPasswordInput.type = 'text';
            confirmPasswordIcon.classList.remove('bi-eye-slash-fill');
            confirmPasswordIcon.classList.add('bi-eye-fill');
        } else {
            confirmPasswordInput.type = 'password';
            confirmPasswordIcon.classList.remove('bi-eye-fill');
            confirmPasswordIcon.classList.add('bi-eye-slash-fill');
        }
    });

</script>
<!--bootstrap js-->
<script src="{{ URL::asset('build/js/bootstrap.bundle.min.js') }}"></script>
<!--plugins-->
<script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/bs-stepper/js/main.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
