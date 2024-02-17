<!DOCTYPE html> 
<html lang="en">
	
<!-- doccure/  30 Nov 2019 04:11:34 GMT -->
<head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<title>Agendei</title>
		
		<!-- Favicons -->
		<link type="image/x-icon" href="{{asset('template1/assets/img/favicon.png')}}" rel="icon">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{asset('template1/assets/css/bootstrap.min.css')}}">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{asset('template1/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
		<link rel="stylesheet" href="{{asset('template1/assets/plugins/fontawesome/css/all.min.css')}}">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="{{asset('template1/assets/css/style.css')}}">
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="{{asset('template1/assets/js/html5shiv.min.js')}}"></script>
			<script src="{{asset('template1/assets/js/respond.min.js')}}"></script>
		<![endif]-->
        <script src="{{asset('template1/assets/js/html5shiv.min.js')}}"></script>
			<script src="{{asset('template1/assets/js/respond.min.js')}}"></script>
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> --}}
	    @vite(['resources/css/app.css', 'resources/js/app.js'])
	
	</head>
	<body>
		<!-- Main Wrapper -->
		<div class="main-wrapper" id="app">
			<!-- Header -->
			<header class="header">
				<nav class="navbar navbar-expand-lg header-nav">
					<div class="navbar-header">
						<a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</router-link>
						<router-link to="/login" class="navbar-brand logo">
							<h3 style="color: #f7784a; font-weight: bold;">LetsPlay</h3>
						</router-link>
					</div>
					<div class="main-menu-wrapper">
						<div class="menu-header">
							<router-link to="/login" class="menu-logo">
								<h3>Agendei</h3>
							</router-link>
							<a id="menu_close" class="menu-close" href="javascript:void(0);">
								<i class="fas fa-times"></i>
							</router-link>
						</div>
						<ul class="main-nav">
							<li class="active">
								<router-link to="/">Home</router-link>
							</li>
							<li class="has-submenu">
								<router-link to="/login">Passo a Passo <i class=""></i></router-link>
								
							</li>	
							<li class="has-submenu">
								<router-link to="/login">Novidades <i class=""></i></router-link>
								
							</li>	
							<li class="has-submenu">
								<router-link to="/login">Agendar <i class=""></i></router-link>
								
							</li>
							<li>
								<router-link to="/login" >Baixar App</router-link>
							</li>
							<li class="login-link">
								<router-link to="/login">Login / Signup</router-link>
							</li>
						</ul>		 
					</div>		 
					<ul class="nav header-navbar-rht">
						
						<li class="nav-item">
							<router-link class="nav-link header-login" to="/login">Login / Signup </router-link>
						</li>
					</ul>
				</nav>
			</header>
			<!-- /Header -->
			
			<router-view></router-view>
			
			<!-- Footer -->
			<footer class="footer">
				
				<!-- Footer Top -->
				<div class="footer-top">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-about">
									<div class="footer-logo">
										<img src="{{asset('template1/assets/img/footer-logo.png')}}" alt="logo">
									</div>
									<div class="footer-about-content">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
										<div class="social-icon">
											<ul>
												<li>
													<router-link to="/login"><i class="fab fa-facebook-f"></i> </router-link>
												</li>
												<li>
													<router-link to="/login"><i class="fab fa-twitter"></i> </router-link>
												</li>
												<li>
													<router-link to="/login"><i class="fab fa-linkedin-in"></i></router-link>
												</li>
												<li>
													<router-link to="/login"><i class="fab fa-instagram"></i></router-link>
												</li>
												<li>
													<router-link to="/login"><i class="fab fa-dribbble"></i> </router-link>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">Links Rapidos</h2>
									<ul>
										<li><router-link to="/login"><i class="fas fa-angle-double-right"></i> Procurar por Quadras</router-link></li>
										<li><router-link to="/login"><i class="fas fa-angle-double-right"></i> Login</router-link></li>
										<li><router-link to="/login"><i class="fas fa-angle-double-right"></i> Register</router-link></li>
										<li><router-link to="/login"><i class="fas fa-angle-double-right"></i> Agendar</router-link></li>
										
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-contact">
									<h2 class="footer-title">Contact Us</h2>
									<div class="footer-contact-info">
										<div class="footer-address">
											<span><i class="fas fa-map-marker-alt"></i></span>
											<p> Beira Moçambique </p>
										</div>
										<p>
											<i class="fas fa-phone-alt"></i>
											8412345567
										</p>
										<p class="mb-0">
											<i class="fas fa-envelope"></i>
											padel@example.com
										</p>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
						</div>
					</div>
				</div>
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
                <div class="footer-bottom">
					<div class="container-fluid">
					
						<!-- Copyright -->
						<div class="copyright">
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="copyright-text">
										<p class="mb-0"><router-link to="/">ConnectUs</router-link></p>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
								
									<!-- Copyright Menu -->
									<div class="copyright-menu">
										<ul class="policy-menu">
											<li><router-link to="/">Terms and Conditions</router-link></li>
											<li><router-link to="/">Policy</router-link></li>
										</ul>
									</div>
									<!-- /Copyright Menu -->
									
								</div>
							</div>
						</div>
						<!-- /Copyright -->
						
					</div>
				</div>
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->
		   
	   </div>
	   <!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="{{asset('template1/assets/js/jquery.min.js')}}')}}"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="{{asset('template1/assets/js/popper.min.js')}}')}}"></script>
		<script src="{{asset('template1/assets/js/bootstrap.min.js')}}')}}"></script>
		
		<!-- Slick JS -->
		<script src="{{asset('template1/assets/js/slick.js')}}"></script>
		
		<!-- Custom JS -->
		<script src="{{asset('template1/assets/js/script.js')}}"></script>
		
	</body>

<!-- doccure/  30 Nov 2019 04:11:53 GMT -->
</html>