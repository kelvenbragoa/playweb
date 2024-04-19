<!DOCTYPE html>
<html lang="pt">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="M+D - InoGest">
	<meta name="author" content="M+D - InoGest">
	<meta name="keywords" content="M+D - InoGest">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<link rel="shortcut icon" href="{{asset('files/img/sys/logoinogesticon.png')}}" />
	<link href="{{asset('template2/css/app.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('toastr.min.css')}}" />
	<title>LetsPlayPadel</title>
</head>

<body>
	<div id="app" class="wrapper">
		<nav id="sidebar" class="sidebar">
			<div class="sidebar-content js-simplebar">
				<router-link class="sidebar-brand" to="/owner/dashboard">
          			<span class="align-middle">LetsPlayPadel</span>
        		</router-link>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Páginas
					</li>

					<li class="sidebar-item">
						<router-link class="sidebar-link" to="/owner/dashboard">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Painel Geral</span>
						</router-link>
					</li>

					<li class="sidebar-header">
						Lets Play Padel
					</li>

					{{-- <li class="sidebar-item">
						<router-link class="sidebar-link" to="/owner/users">
							<i class="align-middle" data-feather="user"></i> <span class="align-middle">Usuários</span>
						</router-link>
					</li> --}}

					<li class="sidebar-item">
						<router-link class="sidebar-link" to="/owner/courts">
							<i class="align-middle" data-feather="user"></i> <span class="align-middle">Quadras</span>
						</router-link>
					</li>

					<li class="sidebar-item">
						<router-link class="sidebar-link" to="/owner/prices">
							<i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Preços</span>
						</router-link>
					</li>

					<li class="sidebar-item">
						<router-link class="sidebar-link" to="/owner/recharges">
							<i class="align-middle" data-feather="activity"></i> <span class="align-middle">Recargas</span>
						</router-link>
					</li>

					<li class="sidebar-item">
						<router-link class="sidebar-link" to="/owner/club">
							<i class="align-middle" data-feather="box"></i> <span class="align-middle">Meu Clube</span>
						</router-link>
					</li>	
					<li class="sidebar-item">
						<router-link class="sidebar-link" to="/owner/profile">
							<i class="align-middle" data-feather="settings"></i> <span class="align-middle">Perfil</span>
						</router-link>
					</li>	
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle d-flex">
					<i class="hamburger align-self-center"></i>
				</a>

				
				


				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">{{Auth::user()->unreadNotifications->count()}}</span>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									{{Auth::user()->unreadNotifications->count()}} Novas notificações
								</div>

								<div class="list-group">

									@foreach (Auth::user()->notifications->take(3) as $item)
										<router-link to="/owner/notifications" class="list-group-item">
											<div class="row g-0 align-items-center">
												<div class="col-2">
													<i class="text-warning" data-feather="bell"></i>
												</div>
												<div class="col-10">
													<div class="text-dark">{{ Str::words($item->data['data'], 10) }}</div>
                                        			<div class="text-muted small mt-1">{{$item->created_at}}</div>
												</div>
											</div>
										</router-link >
                            		@endforeach	
								</div>

								<div class="dropdown-menu-footer">
									<router-link to="/owner/notifications" class="text-muted" href="#">Mostrar todas notificações</router-link>
								
								</div>
							</div>
						</li>
						
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
								<img src="{{asset('template1/assets/img/footer-logo.png')}}" class="avatar img-fluid rounded mr-2" alt="{{Auth()->user()->firstName}} {{Auth()->user()->lastName}}" /> <span class="text-dark">{{Auth()->user()->firstName}} {{Auth()->user()->lastName}}</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
							
								<a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="user"></i> Perfil</a>
								<a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="help-circle"></i>Ajuda</a>
								<div class="dropdown-divider"></div>
								<form action="{{route('logout')}}" id="form" method="POST">
									@csrf
								  <button type="submit" class="btn btn-outline-primary mx-3 mt-2 d-block">Sair</button>
								  </form>
								
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">

					<router-view></router-view>

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-left">
							<p class="mb-0">
								<a href="#" class="text-muted"><strong>LetsPlayPadel</strong></a> &copy; {{ date('Y')}}
							</p>
						</div>
						<div class="col-6 text-right">
							<ul class="list-inline">
								<li class="list-inline-item">
									<router-link to="/owner/dashboard" class="text-muted" href="#">Ajuda</router-link>
								</li>
								<li class="list-inline-item">
									<router-link to="/owner/dashboard" class="text-muted" href="#">Termos e Privacidade</router-link>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="{{asset('template2/js/app.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
	<script>
		window.user = {!! Auth::user() !!}
	</script>
</body>

</html>