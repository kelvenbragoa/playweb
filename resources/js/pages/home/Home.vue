<script setup>

import {onMounted, ref, reactive,watch} from 'vue';
import axios from 'axios';
import moment from 'moment'
import {debounce} from 'lodash';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import VueFeather from 'vue-feather';


const searchQuery = ref(null);
const loadingDiv = ref(true);
const loadingButtonDelete = ref(false);



const retriviedData = ref({'data': []})

let dataIdBeingDeleted = ref(null);


 const getData = async () => {
  axios.get(`/home-data`)
       .then((response)=>{
        retriviedData.value = response.data.clubs;
        loadingDiv.value=false;
		console.log(retriviedData)
        
       })

       
}

const confirmDeletion = (data) => {

dataIdBeingDeleted = data.id;

$('#deleteModal').modal('show');
// axios.post('/categories',values).then((response)=>{

//   categories.value.unshift(response.data);
//   $('#createCategory').modal('hide');
//   resetForm();
// })
};


watch(searchQuery,debounce(()=>{
    getData();
},300));

onMounted(()=>{
    getData();
    
})
</script>
<template>
		<div v-if="!loadingDiv">
    	<!-- Home Banner -->
			<section class="section section-search">
				<div class="container-fluid">
					<div class="banner-wrapper">
						<div class="banner-header text-center">
							
							<h1>FÁCIL E RÁPIDO PARA AGENDAR</h1>
							<p>Conheça as quadras
								disponíveis na sua cidade!</p>
						</div>
                         
						<!-- Search -->
						<div class="search-box">
							<form action="templateshub.net">
								<div class="form-group search-location">
									<input type="text" class="form-control" placeholder="Search Location">
									<span class="form-text">Baseado na sua localização</span>
									
								</div>
								<div class="form-group search-info">
									<input type="text" class="form-control" placeholder="Digite o nome da cidade">
									<span class="form-text">Ex : Maputo</span>
								</div>
								<button type="submit" class="btn btn-primary search-btn"><i class="fas fa-search"></i> <span>Search</span></button>
							</form>
						</div>
						<!-- /Search -->
						
					</div>
				</div>
			</section>
			<!-- /Home Banner -->
		
			<!-- Clinic and Specialities -->
			
			<!-- Clinic and Specialities -->
		  
			<!-- Popular Section -->
			<section class="section section-doctor">
				<div class="container-fluid">
				   <div class="row">
						<div class="col-lg-4">
							<div class="section-header ">
								<h1 style="color: #f7784a;">AGENDE A SUA QUADRA AQUI!</h1>
								<p>Selecione a quadra que deseja jogar</p>
							</div>
							<div class="about-content">
								<p>O App LetsPlay padel é onde os jogadores encontram as quadras, visualizam os horários disponíveis, agendam e pagam via app.</p>
								<p>Esta é a maneira mais fácil de voce encontrar o melhor horario para jogar</p>					
								
							</div>
						</div>
						
						<div class="col-lg-8">
							<div class="row">
							
								<!-- Doctor Widget -->
								<div class="profile-widget" v-for="(actualData) in retriviedData" :key="actualData.id">
									<div class="doc-img">
										<router-link :to="'/clubs/'+actualData.id">
											<img class="img-fluid" alt="User Image" src="/letsplay.png">
										</router-link>
										<a href="javascript:void(0)" class="fav-btn">
											<i class="far fa-bookmark"></i>
										</a>
									</div>
									<div class="pro-content">
										<h3 class="title">
											
											<i class="fas fa-check-circle verified"></i><p class="speciality">{{actualData.name}}</p>
										</h3>
										<p class="speciality">{{actualData.description}}</p>
									
										<!-- <div class="rating">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<span class="d-inline-block average-rating">(17)</span>
										</div> -->
										<ul class="available-info">
											<li>
												
												<i class="fas fa-map-marker-alt"></i> {{actualData.address}} / {{ actualData.province==null ? '' : actualData.province.name}} , Moçambique
											</li>
											<li>
												<i class="far fa-clock"></i> Disponivel todos dias
											</li>
											<li>
												<i class="far fa-money-bill-alt"></i> {{actualData.min_price}} MT 
												<i class="fas fa-info-circle" data-toggle="tooltip" ></i>
											</li>
										</ul>
										<div class="row row-sm">
											<div class="col-6">
												<router-link :to="'/clubs/'+actualData.id" class="btn view-btn">Ver detalhes</router-link>
											</div>
											<div class="col-6">
												<router-link :to="'/clubs/'+actualData.id" class="btn book-btn">Agendar</router-link>
											</div>
										</div>
									</div>
								</div>
								<!-- /Doctor Widget -->
						
								
								
							</div>
						</div>
				   </div>
				</div>
			</section>
			<!-- /Popular Section -->
		   
		</div>
		<div v-else>
			
			
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    Loading...
                </div>
       
		</div>
</template>