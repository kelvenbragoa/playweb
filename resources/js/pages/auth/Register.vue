<template>
    	<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					
					<div class="row">
						<div class="col-md-8 offset-md-2">
								
							<!-- Register Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="template1/assets/img/features/hand-drawn-creative-padel-illustration_23-2149225433.avif" class="img-fluid" alt="Doccure Register">	
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Registro  <router-link to="/register">E admin?</router-link></h3>
										</div>
										
										<!-- Register Form -->
										<form action="https://dreamguys.co.in/demo/doccure/doctor-dashboard.html">
											<div class="form-group form-focus">
												<input type="text" class="form-control floating">
												<label class="focus-label">Nome</label>
											</div>
											<div class="form-group form-focus">
												<input type="text" class="form-control floating">
												<label class="focus-label">Contacto</label>
											</div>
											<div class="form-group form-focus">
												<input type="password" class="form-control floating">
												<label class="focus-label">Criar Senha</label>
											</div>
											<div class="text-right">
												<router-link class="forgot-link" to="/login">Ja tem uma conta?</router-link>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Entrar</button>
											<div class="login-or">
												<span class="or-line"></span>
												<span class="span-or">ou</span>
											</div>
											<div class="row form-row social-login">
												<div class="col-6">
													<router-link to="/login" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</router-link>
												</div>
												<div class="col-6">
													<router-link to="/login" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</router-link>
												</div>
											</div>
										</form>
										<!-- /Register Form -->
										
									</div>
								</div>
							</div>
							<!-- /Register Content -->
								
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
</template>