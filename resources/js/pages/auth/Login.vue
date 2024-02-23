<script setup>

import axios from 'axios';
import {reactive, ref} from 'vue';


    const form = reactive ({
        email: '',
        password: ''
    });

    const loading = ref(false);

    const errorMessage = ref('');
    


    const handleSubmit = () => {
      loading.value = true;
      errorMessage.value = '';
        axios.post('/login',{
          email: form.email.toLowerCase(),
          password:form.password
        })
        .then((response)=>{
            console.log(response.data)
            
            if(response.data.role_id == 1){
              window.location.href="/admin/dashboard";
            }

            if(response.data.role_id == 2){
              window.location.href="/owner/dashboard";
            }
          

            if(response.data.role_id == 3){
              window.location.href="/user/home";
            }

          
            // window.location.href="/admin/dashboard";
        })
        .catch((error)=>{


          errorMessage.value = error.response.data.message
          
        })
        .finally(()=>{
          loading.value = false;
        })
    }


</script>
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
											<div v-if="errorMessage" class="alert alert-danger" role="alert">
												<div class="m-2">
													{{errorMessage}}
												</div>
											</div>
										</div>
										<form @submit.prevent="handleSubmit">
											<div class="form-group form-focus">
												<input type="email" class="form-control floating" v-model="form.email"  required>
												<label class="focus-label">Email</label>
											</div>
											<div class="form-group form-focus">
												<input type="password" class="form-control floating" v-model="form.password" required>
												<label class="focus-label">Senha</label>
											</div>
											<!-- <div class="text-right">
												<router-link class="forgot-link" to="/login">Esqueceu a sua senha ?</router-link>
											</div> -->
											
											<button type="submit" class="btn btn-primary btn-block btn-lg login-btn"  :disabled="loading">
                                            <div v-if="loading" class="spinner-border spinner-border-sm" role="status"></div>
                                            <span v-else>Login</span>
                                            </button>
											
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