<!DOCTYPE html>
<html lang="zxx">
<head>
	<meta charset="UTF-8">
	<title>Fitmax - Program</title>
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

<body id="home" class="page-program">
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
                                href="https://wa.me/+6285184741788">085184741788</a></li>
                        <li><i class="fa fa-clock-o" aria-hidden="true"></i>Mon to Fri : 6:00 AM to 8:00 PM | Sat 6:00
                            AM to 6:00 PM | Sun:
                            Closed </li>
                    </ul>
                </div>
                <div class="header-right">
                    <ul class="social-list">
                        <li><a target="_blank" href="https://wa.me/+6285184741788"><i class="fa fa-whatsapp"
                                    aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="https://www.instagram.com/flozorsgym/"><i class="fa fa-instagram"
                                    aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="https://maps.app.goo.gl/r6iY1YkYoXq7tNkt6"><i
                                    class="fa fa-map-marker" aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="mailto:flozorsgym@gmail.com"><i class="fa fa-envelope-o"
                                    aria-hidden="true"></i></a></li>
                    </ul>
                    <a href="{{route("member.send-otp")}}" class="btn-login">Login</a>
                </div>
            </div>
        </div>
        {{-- <div class="header-menu"> --}}
        <div class="container">
            <div class="header-logo">
                <a href="{{route("landing_page")}}" class="logo img-thumbnail">
                    <img src="{{asset("landing_page/assets/img/10.svg")}}" class="card-img-top" alt="logo">
                </a>
                <p class="me-5">Flozor's Gym</p>
            </div>
        </div>
        {{-- </div> --}}
    </header>
	<!-- =============== HEADER END =============== -->

	<!-- =============== HEADER-TITLE =============== -->
	<section class="s-header-title" style="background-image: url(landing_page/assets/img/bg-1-min.png);">
		<div class="container">
			<h1 class="title">Monthly Membership</h1>
			<ul class="breadcrambs">
				<li><a href="{{route("landing_page")}}">Home</a></li>
				<li>Monthly Membership</li>
			</ul>
		</div>
	</section>
	<!-- ============= HEADER-TITLE END ============= -->

	<!-- ============== S-ABOUT-PROGRAM ============== -->
	<section class="s-about">
		<div class="container">
			<img class="about-effect-tringle" src="{{asset("landing_page/assets/img/tringle-about-top.svg")}}" alt="img">
			<div class="row about-row">
				<div class="col-md-5 about-img-col">
					<div class="about-img-cover">
						<div class="about-img-1">
							<img class="about-img-effect-1" src="{{asset("landing_page/assets/img/square-yellow.svg")}}" alt="img">
							<img class="about-img-effect-2" src="{{asset("landing_page/assets/img/group-circle-2.svg")}}" alt="img">
							<img src="{{asset("landing_page/assets/img/programs-3.jpg")}}" style="max-height: 422px; max-width:422px" alt="img">
						</div>
						<div class="about-img-2">
							<img src="{{asset("landing_page/assets/img/programs-1.jpg")}}" style="max-height: 309px; max-width:312px" alt="img">
						</div>
					</div>
				</div>
				<div class="col-md-7 about-info-cover">
					<h2 class="title-decor">About <span>Program Monthly Membership</span></h2>
					<div class="text">
						<p>Unlock your fitness journey with monthly membership program starting only from Rp. 325.000,-/month, huge discounts on longer terms. Start your transformation today with unbeatable value and premium benefits!</p>
					</div>
					<ul class="about-cont">
						<li><i class="fa fa-phone" aria-hidden="true"></i><a  href="https://wa.me/+6285184741788">085184741788</a></li>
						<li><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:flozorsgym@gmail.com">flozorsgym@gmail.com</a></li>
					</ul>
					<ul class="social-list">
						<li><a target="_blank" href="https://wa.me/+6285184741788"><i class="fa fa-whatsapp"
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
	</section>
	<!-- ============ S-ABOUT-PROGRAM END ============ -->

	<!-- ============== S-OUR-PROGRAMS ============== -->
	<section class="s-club-cards">
		<div class="container">
			<h2 class="title-decor">Program <span>Price</span></h2>
			<p class="slogan"> Untuk member baru, ada tambahan biaya registrasi sebesar Rp.75.000,- yang dapat ditukarkan dalam bentuk kartu anggota (e-money).			</p>
			<div class="row mb-3">
				<div class="col-md-4 club-card-col">
					<div class="club-card-item">
						<div class="price-cover">
							<div class="date"><span>1 months</span></div>
						</div>
						<ul class="list">
							<li>Rp.325.000</li>
							<li>Masa berlaku 31 hari dihitung sejak tanggal lunas pembayaran.</li>
						</ul>
						<a href="{{route("member.register-get-package")}}" class="btn">order now</a>
					</div>
				</div>
				<div class="col-md-4 club-card-col">
					<div class="club-card-item">
						<div class="price-cover">
							<div class="date"><span>2 months</span></div>
						</div>
						<ul class="list">
							<li><s style="opacity: 50%">Rp. 660.000</s> Rp.560.000</li>
							<li>Masa berlaku 62 hari dihitung sejak tanggal lunas pembayaran.</li>
						</ul>
						<a href="{{route("member.register-get-package")}}" class="btn">order now</a>
					</div>
				</div>
				<div class="col-md-4 club-card-col mb-3">
					<div class="club-card-item">
						<div class="price-cover">
							<div class="date"><span>3 months</span></div>
						</div>
						<ul class="list">
							<li><s style="opacity: 50%">Rp.985.000</s> Rp.760.000</li>
							<li>Masa berlaku 93 hari dihitung sejak tanggal lunas pembayaran.</li>
						</ul>
						<a href="{{route("member.register-get-package")}}" class="btn">order now</a>
					</div>
				</div>
                
			</div>
            <div class="row justify-center">
				<div class="col-md-4 club-card-col">
					<div class="club-card-item">
						<div class="price-cover">
							<div class="date"><span>6  months</span></div>
						</div>
						<ul class="list">
							<li><s style="opacity: 50%">Rp.1.960.000</s> Rp.1.260.000</li>
							<li>Masa berlaku 186 hari dihitung sejak tanggal lunas pembayaran.</li>
						</ul>
						<a href="{{route("member.register-get-package")}}" class="btn">order now</a>
					</div>
				</div>
               
				<div class="col-md-4 club-card-col">
					<div class="club-card-item">
						<div class="price-cover">
							<div class="date"><span>1 Year</span></div>
						</div>
						<ul class="list">
							<li><s style="opacity: 50%">Rp.3.910.000</s> Rp.2.010.000</li>
							<li>Masa berlaku 372 hari dihitung sejak tanggal lunas pembayaran.</li>
						</ul>
						<a href="{{route("member.register-get-package")}}" class="btn">order now</a>
					</div>
				</div>
                
			</div>
		</div>
	</section>
	<!-- ============ S-OUR-PROGRAMS END ============ -->

	<!-- ================ S-CONTACTS ================ -->
	<section class="s-contacts" style="background-image: url(assets/img/bg-contacts.svg);">
		<div class="container">
			<h2 class="title-decor">Contact <span>Us</span></h2>
			<p class="slogan">If you have any questions, please contact us.</p>
			<div class="row">
				<div class="col-md-5 col-lg-4">
					<div class="contact-item">
						<div class="contact-item-left">
							<img src="{{asset("landing_page/assets/img/icon-1.svg")}}" alt="img">
							<h4>need help</h4>
						</div>
						<div class="contact-item-right">
							<ul class="contact-item-list">
								<li><a href="https://wa.me/+6285184741788">085184741788</a></li>
							</ul>
						</div>
					</div>
                    <div class="mb-5">
						
					</div>
					<div class="contact-item mt-5">
						<div class="contact-item-left">
							<img src="{{asset("landing_page/assets/img/icon-3.svg")}}" alt="img">
							<h4>address</h4>
						</div>
						<div class="contact-item-right">
							<ul class="contact-item-list">
								<li>Jl. Puspowarno Tengah No.6, Salamanmloyo, Kec. Semarang Barat, Kota Semarang, Jawa Tengah 50149</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-7 col-lg-8">
					<form action="{{route("post_question")}}" method="POST">
						@csrf
						<ul class="form-cover">
							<li class="inp-name">
								<label>Name * (required)</label>
								<input id="name" required type="text" name="name">
							</li>
							<li class="inp-email">
								<label>Phone * (required)</label>
								<input id="phone" required type="text" name="phone" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
							</li>
							<li class="inp-text">
								<label>Message * (required)</label>
								<textarea id="comments" required name="comments"></textarea>
							</li>
						</ul>
						<div class="checkbox-wrap">
							<div class="checkbox-cover">
								<input type="checkbox" name="checkbox" required>
								<p>By using this form you agree with the storage and handling of your data by this website.</p>
							</div>
						</div>
						<div class="btn-form-cover">
							<button type="submit" class="btn">send comment</button>
						</div>
					</form>

					{{-- success form --}}
					@if (session('success'))
						<div class="alert alert-success mt-3">
							{{ session('success') }}
						</div>
					{{-- erorr form --}}
					@elseif (session('error'))
						<div class="alert alert-danger mt-3">
							{{ session('error') }}
						</div>
					@endif
				</div>
			</div>
		</div>
	</section>
	<!-- ============== S-CONTACTS-END ============== -->

	<!-- ================== FOOTER ================== -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-4 footer-item-logo">
                    <a href="{{route("landing_page")}}" class="logo-footer"><img src="{{asset("landing_page/assets/img/10.svg")}}" alt="logo"></a>
                    <p>Flozors Gym, founded in 2002 by Frans Lee, offers top service and a welcoming atmosphere for fitness enthusiasts.</p>
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
                <div class="col-sm-6 col-lg-4 footer-item">
                    <h3>Contact us</h3>
                    <ul class="footer-cont">
                        <li><i class="fa fa-whatsapp" aria-hidden="true"></i><a href="https://wa.me/+6285184741788">085184741788</a>
                        </li>
                        <li><i class="fa fa-envelope" aria-hidden="true"></i><a
                                href="mailto:flozorsgym@gmail.com">flozorsgym@gmail.com</a></li>
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i><a href="https://maps.app.goo.gl/r6iY1YkYoXq7tNkt6">Jl. Puspowarno Tengah No.6, Salamanmloyo, Kec. Semarang Barat, Kota Semarang, Jawa Tengah 50149</a></li>
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
	<script src="assets/js/jquery-2.2.4.min.js"></script>
	<script src="assets/js/scripts.js"></script>
    <script src="{{asset("landing_page/assets/js/jquery-2.2.4.min.js")}}"></script>
    <script src="{{asset("landing_page/assets/js/scripts.js")}}"></script>
</body>
</html>