<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Flozor's Gym</title>
    <!-- =================== META =================== -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{asset("landing_page/assets/img/9.png")}}">

    <!-- =================== STYLE =================== -->
    <link rel="stylesheet" href="{{asset("landing_page/assets/css/slick.min.css")}}">
    <link rel="stylesheet" href="{{asset("landing_page/assets/css/bootstrap-grid.css")}}">
    <link rel="stylesheet" href="{{asset("landing_page/assets/css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="{{asset("landing_page/assets/css/style.css")}}">

</head>

<style>
   .image-carousel {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .carousel-images {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .carousel-image {
        min-width: 100%;
        transition: opacity 0.5s ease-in-out;
    }

    .carousel-control {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        z-index: 10;
    }

    .prev {
        left: 10px;
    }

    .next {
        right: 10px;
    }

</style>

<body id="home">
    <!--================ PRELOADER ================-->
    <div class="preloader-cover">
        <div id="cube-loader">
            <div class="caption">
                <div class="cube-loader">
                    <div class="cube loader-1"></div>
                    <div class="cube loader-2"></div>
                    <div class="cube loader-4"></div>
                    <div class="cube loader-3"></div>
                </div>
            </div>
        </div>
    </div>
    <!--============== PRELOADER END ==============-->

    <!-- ================= HEADER ================= -->
    <header class="header">
        <div class="top-panel">
            <div class="container">
                <div class="header-left">
                    <ul class="header-cont">
                        <li><i class="fa fa-phone" aria-hidden="true"></i><a
                                href="https://wa.me/+628170706999">08170706999</a></li>
                        <li><i class="fa fa-clock-o" aria-hidden="true"></i>Mon to Fri : 6:00 AM to 8:00 PM | Sat 6:00
                            AM to 6:00 PM | Sun:
                            Closed </li>
                    </ul>
                </div>
                <div class="header-right">
                    <ul class="social-list">
                        <li><a target="_blank" href="https://wa.me/+628170706999"><i class="fa fa-whatsapp"
                                    aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="https://www.instagram.com/flozorsgym/"><i class="fa fa-instagram"
                                    aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="https://maps.app.goo.gl/r6iY1YkYoXq7tNkt6"><i
                                    class="fa fa-map-marker" aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="mailto:flozorsgym@gmail.com"><i class="fa fa-envelope-o"
                                    aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- <div class="header-menu"> --}}
        <div class="container">
            <div class="header-logo ">
                <a href="{{route("landing_page")}}" class="logo img-thumbnail">
                    <img src="{{asset("landing_page/assets/img/10.svg")}}" class="card-img-top" alt="logo">
                </a>
                <p class="me-5" style="font-size:20px">FLOZOR'S GYM</p>
                {{-- jika ukuran hp maka ada tombol login --}}
                <a href="{{route("member.send-otp")}}" class="btn-login">Login</a>
            </div>

        </div>
        {{-- </div> --}}
    </header>
    <!-- =============== HEADER END =============== -->

    <!-- ============ S-CROSSFIT-SLIDER ============ -->
    <section class="s-crossfit-slider">
        <div class="crossfit-slider">
            <div class="crossfit-slide">
                <div class="crossfit-slider-effect effect-1">
                    <div data-hover-only="true" class="scene">
                        <span class="scene-item" data-depth="0.2"
                            style="background-image: url(landing_page/assets/img/effect-1.svg);"></span>
                    </div>
                </div>
                <div class="crossfit-slider-effect effect-2">
                    <div data-hover-only="true" class="scene">
                        <span class="scene-item" data-depth="0.4"
                            style="background-image: url(landing_page/assets/img/effect-2.svg);"></span>
                    </div>
                </div>
                <div class="crossfit-slide-bg" style="background-image: url(landing_page/assets/img/hero1.jpg);"></div>
                <div class="container">
                    <div class="crossfit-slide-cover">
                        <h2 class="title"> <span>YOU</span> VS <span>YOU</span></h2>
                        <p>Every day is a chance to become a better version of yourself. Challenge yourself to push past
                            limits and overcome weaknesses. Life is too short to be held back by unhealthy habits. Push
                            yourself, stay committed, and let your determination drive you forward. In the end, it’s you
                            against you. Keep striving, because you are worth it.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-navigation">
            <div class="container">
                <div class="slider-navigation-cover"></div>
            </div>
        </div>
    </section>
    <!-- ========== S-CROSSFIT-SLIDER END ========== -->

    <!-- ================ S-CROSSFIT ================ -->
    <section class="s-crossfit">
        <div class="container">
            <img src="{{asset("landing_page/assets/img/placeholder-all.png")}}"
                data-src="{{asset("landing_page/assets/img/group-circle-2.svg")}}" alt="img"
                class="crossfit-icon-1 rx-lazy">
            <h2 class="title-decor">Welcome To <span>Flozor's Gym</span></h2>
            <p class="slogan">Flozors Gym has a dynamic history rooted in dedication to fitness and community. Founded
                in 2002 by Frans Lee as Scorpion Gym on Kranggan Road, it quickly gained popularity over three years. We
                rebranded as Flozors Gym, reflecting our evolution, settling at its current location on Puspowarno
                Tengah No.6, Salamanmloyo, Semarang Barat, 50149. Throughout our journey, we've remained committed to
                providing the best service and delivering healthy results in a warm and inviting atmosphere that feels
                like home for all fitness enthusiasts.
            </p>
        </div>
    </section>
    <!-- ============== S-CROSSFIT END ============== -->

    <!-- ============== S-OUR-PROGRAMS ============== -->
    <section class="s-our-programs" style="background-image: url(landing_page/assets/img/bg-programs.jpg);">
        <div class="mask"></div>
        <div class="our-programs-effect" style="background-image: url(landing_page/assets/img/bg-programs.svg);"></div>
        <div class="container">
            <h2 class="title-decor">Our <span>Programs</span></h2>
            <p class="slogan">Transform your life with our program- designed to reduce cortisol, manage stress
                effectively, and enhance your sleep quality, leading to a more peaceful and rejuvenated you.</p>
            <div class="row">
                <div class="col-sm-6 col-md-3 program-col">
                    <div class="program-item">
                        <div class="program-item-front"
                            style="background-image: url(landing_page/assets/img/programs-3.jpg);">
                            <div class="program-item-inner">
                                <h3>Monthly Membership</h3>
                            </div>
                        </div>
                        <div class="program-item-back"
                            style="background-image: url(landing_page/assets/img/programs-3.jpg);">
                            <div class="program-item-inner">
                                <h3>Monthly Membership</h3>
                                <a href="{{route("program-monthly-membership")}}" class="btn">More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 program-col">
                    <div class="program-item">
                        <div class="program-item-front"
                            style="background-image: url(landing_page/assets/img/programs-2.jpg);">
                            <div class="program-item-inner">
                                <h3>PBC/PBBC</h3>
                            </div>
                        </div>
                        <div class="program-item-back"
                            style="background-image: url(landing_page/assets/img/programs-2.jpg);">
                            <div class="program-item-inner">
                                <h3>Personal Body Care/Personal Beauty Body Care BY Personal Trainer</h3>
                                <a href="{{route("personal-body-care-by-pt")}}" class="btn">More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 program-col">
                    <div class="program-item">
                        <div class="program-item-front"
                            style="background-image: url(landing_page/assets/img/programs-1.jpg);">
                            <div class="program-item-inner">
                                <h3>PBC/PBBC Gold</h3>
                            </div>
                        </div>
                        <div class="program-item-back"
                            style="background-image: url(landing_page/assets/img/programs-1.jpg);">
                            <div class="program-item-inner">
                                <h3>Personal Body Care/Personal Beauty Body Care BY Personal Owner</h3>
                                <a href="{{route("personal-body-care-by-owner")}}" class="btn">More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 program-col">
                    <div class="program-item">
                        <div class="program-item-front"
                            style="background-image: url(landing_page/assets/img/programs-4.jpg);">
                            <div class="program-item-inner">
                                <h3>One Day Pass</h3>
                            </div>
                        </div>
                        <div class="program-item-back"
                            style="background-image: url(landing_page/assets/img/programs-4.jpg);">
                            <div class="program-item-inner">
                                <h3>One Day Pass</h3>
                                <a href="{{route("one-day")}}" class="btn">More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============ S-OUR-PROGRAMS END ============ -->

    <!-- =============== S-OUT-TRAINER =============== -->
    <section class="s-out-trainer" style="background-image: url(assets/img/bg-contacts.svg);">
        <div class="container">
            <h2 class="title-decor">Our <span>Trainer</span></h2>
            <p class="slogan">Meet Our Expert Trainers: Your Path to Fitness Success.</p>
            <div class="row">
                <div class="col-md-6 out-trainer-col">
                    <div class="out-trainer-item">
                        <a href="javascript:void(0);" class="out-trainer-img"><img class="rx-lazy"
                                src="{{asset("landing_page/assets/img/ptFajar.jpg")}}"
                                data-src="{{asset("landing_page/assets/img/ptFajar.jpg")}}" alt="img"></a>
                        <div class="out-trainer-info">
                            <h3><a href="javascript:void(0);">Fadjar</a></h3>
                            <div class="prof">Firm man</div>
                            <p>Fajar adalah seorang instruktur Fitnes yang tegas, suka bertanya pada member dan bertanggung jawab dalam segala apapun, mampu mengajar dengan baik dan bersemangat dalam mengajar.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 out-trainer-col">
                    <div class="out-trainer-item">
                        <a href="javascript:void(0);" class="out-trainer-img"><img class="rx-lazy"
                                src="{{asset("landing_page/assets/img/ptAgus.jpg")}}"
                                data-src="{{asset("landing_page/assets/img/ptAgus.jpg")}}" alt="img"></a>
                        <div class="out-trainer-info">
                            <h3><a href="javascript:void(0);">Agus</a></h3>
                            <div class="prof">Calm Guy</div>
                            <p>Agus adalah instruktur fitness berpengalaman,full power,pendiam tapi selalu memperhatikan membernya & bisa mengajar secara detail sehingga bisa membantu mewujudkan goals yang di inginkan dari para member....</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 out-trainer-col">
                    <div class="out-trainer-item">
                        <a href="javascript:void(0);" class="out-trainer-img"><img class="rx-lazy"
                                src="{{asset("landing_page/assets/img/ptMelky.jpg")}}"
                                data-src="{{asset("landing_page/assets/img/ptMelky.jpg")}}" alt="img"></a>
                        <div class="out-trainer-info">
                            <h3><a href="javascript:void(0);">Melky</a></h3>
                            <div class="prof">Funny guy</div>
                            <p>Melky adalah seorang instruktur Fitness yang lucu, menghibur, dan menyenangkan, dan mampu mengajar dengan detail, dan siap membimbing members sampai body goals yang diinginkan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 out-trainer-col">
                    <div class="out-trainer-item">
                        <a href="#" class="out-trainer-img"><img class="rx-lazy"
                            src="{{asset("landing_page/assets/img/ptclaus.jpg")}}"
                            data-src="{{asset("landing_page/assets/img/ptclaus.jpg")}}" alt="img"></a>
                        <div class="out-trainer-info">
                            <h3><a href="#">Claus</a></h3>
                            <div class="prof">Educated Guy</div>
                            <p>
                                Claus adalah seorang instruktur fitness yang disiplin, selalu mencari ilmu-ilmu yang bagus, memiliki kemampuan mengajar para member dalam latihan yang benar sesuai dengan body goals mereka.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 out-trainer-col">
                    <div class="out-trainer-item">
                        <a href="#" class="out-trainer-img"><img class="rx-lazy"
                                src="{{asset("landing_page/assets/img/anna.jpg")}}"
                                data-src="{{asset("landing_page/assets/img/anna.jpg")}}" alt="img"></a>
                        <div class="out-trainer-info">
                            <h3><a href="#">Anna</a></h3>
                            <div class="prof">Kind-Hearted</div>
                            <p>
                                Anna adalah seorang receptionist yang baik hati, selalu ringan tangan dalam membantu orang-orang di sekitarnnya, mampu mengajari member untuk mencapai body goals member.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============= S-OUT-TRAINER END ============= -->

    <!-- ============== S-TESTIMONIALS ============== -->
    <section class="s-testimonials" style="background-image: url(landing_page/assets/img/bg-testimonials.jpg);">
        <div class="mask"></div>
        <img class="testimonials-effect" src="{{asset("landing_page/assets/img/bg-testimonials.svg")}}" alt="effect">
    <div class="container">
        <div class="testimonials-slider">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-slide">
                <p>“{{ $testimonial['text'] }}”</p>
                <img src="{{ $testimonial['profile_image'] }}" alt="img">
                <a href="{{ $testimonial['instagram_url'] }}" class="name">{{ $testimonial['name'] }}</a>
                <div class="prof">our client</div>
            </div>
            @endforeach
        </div>
    </div>
    </section>
    <!-- ============ S-TESTIMONIALS END ============ -->

    <!--================ RELATED POSTS ================-->
    <section class="s-related-posts home-related-posts mb-5">
        <div class="container">
            <h2 class="title-decor">promo <span>news</span>  event</h2>
            <div class="row">
                <!-- Card 1 -->
                <div class="col-md-6 related-post-col">
                    <div class="post-item-cover">
                        <div class="post-header">
                            <div class="related-post-categ">F&B</div>

                            <!-- Image Carousel Start for Card 1 -->
                            <div class="image-carousel" id="carousel1">
                                <div class="carousel-images">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/JusDadaAyam1.jpg')}}"
                                        alt="Healthy Snacks">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/JusDadaAyam2.jpg')}}"
                                        alt="Healthy Snacks">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/JusDadaAyam3.jpg')}}" alt="Healthy Meals">
                                </div>
                                <!-- Carousel Controls -->
                                <button class="carousel-control prev" onclick="prevImage(1)">&#10094;</button>
                                <button class="carousel-control next" onclick="nextImage(1)">&#10095;</button>
                            </div>
                            <!-- Image Carousel End -->

                        </div>
                        <div class="post-content">
                            <h3 class="title">Jus Dada Ayam</h3>
                            <div class="text">
                                <p>Jus Dada Ayam untuk sumber protein (kandungan 1 botol : 80 gr protein), menguatkan
                                    sistem kekebalan tubuh, mudah dicerna, dan mendukung pemulihan otot. Tersedia dalam
                                    rasa coklat, almond, kopi, dan strawberry nanas.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-6 related-post-col">
                    <div class="post-item-cover">
                        <div class="post-header">
                            <div class="related-post-categ">F&B</div>

                            <!-- Image Carousel Start for Card 2 -->
                            <div class="image-carousel" id="carousel2">
                                <div class="carousel-images">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/GreenJuiceandSmoothies1.jpg')}}"
                                        alt="Green Juice">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/GreenJuiceandSmoothies2.jpg')}}"
                                        alt="Green Juice">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/GreenJuiceandSmoothies3.jpg')}}"
                                        alt="Green Juice">
                                </div>
                                <!-- Carousel Controls -->
                                <button class="carousel-control prev" onclick="prevImage(2)">&#10094;</button>
                                <button class="carousel-control next" onclick="nextImage(2)">&#10095;</button>
                            </div>
                            <!-- Image Carousel End -->

                        </div>
                        <div class="post-content">
                            <h3 class="title">Green Juice and Smoothies</h3>
                            <div class="text">
                                <p>Membantu badan tetap fit, menjaga berat badan, kaya akan vitamin, mineral, serat, dan
                                    antioksidan, serta baik untuk membuat kulit menjadi glowing. Smoothies kaya akan
                                    nutrisi dari buah-buahan dan biji-bijian yang mengenyangkan dan meningkatkan energi.
                                    Tersedia dalam berbagai rasa, seperti buah naga, sirsak, mangga, strawberry, dll.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-6 related-post-col">
                    <div class="post-item-cover">
                        <div class="post-header">
                            <div class="related-post-categ">F&B</div>

                            <!-- Image Carousel Start for Card 3 -->
                            <div class="image-carousel" id="carousel3">
                                <div class="carousel-images">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/Camilan_Sehat1.jpg')}}"
                                        alt="Healthy Snacks">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/Camilan_Sehat2.jpg')}}"
                                        alt="Healthy Snacks">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/Snack3.jpg')}}" alt="Healthy Snacks">
                                </div>
                                <!-- Carousel Controls -->
                                <button class="carousel-control prev" onclick="prevImage(3)">&#10094;</button>
                                <button class="carousel-control next" onclick="nextImage(3)">&#10095;</button>
                            </div>
                            <!-- Image Carousel End -->

                        </div>
                        <div class="post-content">
                            <h3 class="title">Camilan Sehat</h3>
                            <div class="text">
                                <p>Beraneka macam camilan diet yang merupakan sumber protein dan lemak sehat, membantu
                                    kamu yang masih suka nyemil tapi mau hidup dengan gaya yang lebih sehat.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-6 related-post-col">
                    <div class="post-item-cover">
                        <div class="post-header">
                            <div class="related-post-categ">F&B</div>

                            <!-- Image Carousel Start for Card 4 -->
                            <div class="image-carousel" id="carousel4">
                                <div class="carousel-images">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/HealthyFood1.jpg')}}"
                                        alt="Healthy Drinks">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/HealthyFood2.jpg')}}"
                                        alt="Healthy Drinks">
                                    <img class="carousel-image" style="max-height: 468px;"
                                        src="{{asset('landing_page/assets/img/HealthyFood3.jpg')}}"
                                        alt="Healthy Drinks">
                                </div>
                                <!-- Carousel Controls -->
                                <button class="carousel-control prev" onclick="prevImage(4)">&#10094;</button>
                                <button class="carousel-control next" onclick="nextImage(4)">&#10095;</button>
                            </div>
                            <!-- Image Carousel End -->

                        </div>
                        <div class="post-content">
                            <h3 class="title">Healthy Food</h3>
                            <div class="text">
                                <p>Solusi praktis untuk kamu yang ingin menjalani hidup sehat, menjaga kondisi tubuh,
                                    dan mengikuti diet khusus tanpa kerepotan merencanakan dan menyiapkan makanan.
                                    Layanan ini memudahkan untuk mencapai tujuan kesehatan dengan nutrisi yang tepat.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================== FOOTER ================== -->
    <section class="s-counter" style="background-image: url(assets/img/bg-2.jpg);">
        <div class="mask"></div>
        <div class="container">
            <h2 class="title-decor">Flozor's <span>Certification</span></h2>
            <p class="slogan">To be a professional coach</p>
            <div id="clockdiv">
                <div class="clock-item">
                    <span class="days"></span>
                    <div class="smalltext">Days</div>
                </div>
                <div class="clock-item">
                    <span class="hours"></span>
                    <div class="smalltext">Hours</div>
                </div>
                <div class="clock-item">
                    <span class="minutes"></span>
                    <div class="smalltext">Minutes</div>
                </div>
                <div class="clock-item">
                    <span class="seconds"></span>
                    <div class="smalltext">Seconds</div>
                </div>
            </div>
            <form class="subscribe-form">
                <input class="inp-form" type="email" name="subscribe" placeholder="Your Phone-Number">
                <button type="submit" class="btn">Subscribe</button>
            </form>
        </div>
    </section>
    <!-- ================== FOOTER ================== -->

    <!-- ================== FOOTER ================== -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-6 footer-item-logo">
                    <a href="{{route("landing_page")}}" class="logo-footer"><img
                            src="{{asset("landing_page/assets/img/10.svg")}}" alt="logo"></a>
                    <p>Flozors Gym, founded in 2002 by Frans Lee, offers top service and a welcoming atmosphere for
                        fitness enthusiasts.</p>
                    <ul class="social-list">
                        <li><a target="_blank" href="https://www.facebook.com/rovadex"><i class="fa fa-facebook"
                                    aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="https://twitter.com/RovadexStudio"><i class="fa fa-twitter"
                                    aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="https://www.youtube.com"><i class="fa fa-youtube"
                                    aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="https://www.instagram.com/rovadex"><i class="fa fa-instagram"
                                    aria-hidden="true"></i></a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-6 footer-item">
                    <h3>Contact us</h3>
                    <ul class="footer-cont">
                        <li><i class="fa fa-whatsapp" aria-hidden="true"></i><a
                                href="https://wa.me/+628170706999">08170706999</a>
                        </li>
                        <li><i class="fa fa-envelope" aria-hidden="true"></i><a
                                href="mailto:flozorsgym@gmail.com">flozorsgym@gmail.com</a></li>
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i><a
                                href="https://maps.app.goo.gl/r6iY1YkYoXq7tNkt6">Jl. Puspowarno Tengah No.6,
                                Salamanmloyo, Kec. Semarang Barat, Kota Semarang, Jawa Tengah 50149</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- ================ FOOTER END ================ -->

    <!--=================== TO TOP ===================-->
    <a class="to-top" href="#home">
        <i class="fa fa-chevron-up" aria-hidden="true"></i>
    </a>
    <!--================= TO TOP END =================-->

    <!--=================== SCRIPT	===================-->

    <script src="{{asset("landing_page/assets/js/jquery-2.2.4.min.js")}}"></script>
    <script src="{{asset("landing_page/assets/js/slick.min.js")}}"></script>
    <script src="{{asset("landing_page/assets/js/rx-lazy.js")}}"></script>
    <script src="{{asset("landing_page/assets/js/parallax.min.js")}}"></script>
    <script src="{{asset("landing_page/assets/js/scripts.js")}}"></script>

    <script>
        let currentIndex = [0, 0, 0, 0]; // Array to store current index for each carousel
        const totalImages = 3; // Set to the exact number of images for each carousel

        function showImage(carouselNumber, index) {
            const carousel = document.querySelector(`#carousel${carouselNumber} .carousel-images`);
            const images = document.querySelectorAll(`#carousel${carouselNumber} .carousel-image`);

            // Ensure the index stays within 0 to totalImages - 1
            if (index >= totalImages) {
                currentIndex[carouselNumber - 1] = 0; // Loop back to the first image
            } else if (index < 0) {
                currentIndex[carouselNumber - 1] = totalImages - 1; // Loop back to the last image
            } else {
                currentIndex[carouselNumber - 1] = index;
            }

            // Calculate offset based on the number of images (max -200% for 3 images)
            const offset = -currentIndex[carouselNumber - 1] * 100;
            carousel.style.transform = `translateX(${offset}%)`;
        }

        function nextImage(carouselNumber) {
            showImage(carouselNumber, currentIndex[carouselNumber - 1] + 1);
        }

        function prevImage(carouselNumber) {
            showImage(carouselNumber, currentIndex[carouselNumber - 1] - 1);
        }

        // Optionally, add auto-slide functionality for each carousel
        setInterval(() => {
            nextImage(1); // Carousel 1
            nextImage(2); // Carousel 2
            nextImage(3); // Carousel 3
            nextImage(4); // Carousel 4
        }, 3000); // Change the image every 3 seconds

    </script>
</body>

</html>
