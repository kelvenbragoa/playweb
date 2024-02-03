<template>
    <!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					
					<div class="row">
						<div class="col-md-8 offset-md-2">
							
							<!-- Login Tab Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="template1/assets/img/features/hand-drawn-creative-padel-illustration_23-2149225433.avif" class="img-fluid" alt="Doccure Login">	
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Login no  <span>Agendei</span></h3>
										</div>
										<form action="https://dreamguys.co.in/demo/doccure/index.html">
											<div class="form-group form-focus">
												<input type="email" class="form-control floating">
												<label class="focus-label">Email</label>
											</div>
											<div class="form-group form-focus">
												<input type="password" class="form-control floating">
												<label class="focus-label">Senha</label>
											</div>
											<div class="text-right">
												<router-link class="forgot-link" to="/login">Esqueceu a sua senha ?</router-link>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Login</button>
											<div class="login-or">
												<span class="or-line"></span>
												<span class="span-or">Ou</span>
											</div>
											<div class="row form-row social-login">
												<div class="col-6">
													<router-link to="#" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</router-link>
												</div>
												<div class="col-6">
													<router-link to="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</router-link>
												</div>
											</div>
											<div class="text-center dont-have">Não tem conta? <router-link to="/register">Registrar</router-link></div>
										</form>
									</div>
								</div>
							</div>
							<!-- /Login Tab Content -->
								
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
</template>