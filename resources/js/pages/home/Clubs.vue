<script setup>

import {onMounted, ref, reactive,watch} from 'vue';
import axios from 'axios';
import moment from 'moment'
import {debounce} from 'lodash';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import VueFeather from 'vue-feather';
import { useRouter} from "vue-router";

const searchQuery = ref(null);
const loadingDiv = ref(true);
const loadingButtonDelete = ref(false);
const router = useRouter();


// const retrievedData = ref({'data': []})
const retrievedData = ref([])
const club = ref([])
let dataIdBeingDeleted = ref(null);



const getData = async () => {
  axios.get(`/home-clubs/${router.currentRoute.value.params.id}`, 
  {
        params:{
          query: searchQuery.value
        }
      })
       .then((response)=>{
        loadingDiv.value=false;
        retrievedData.value = response.data.courts;
        club.value = response.data.club;
     
       }).catch(()=>{
        loadingDiv.value=false;
       })
}

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
							<p>{{ club.name }}</p>
							<p>{{ club.address }}</p>
						</div>
                         
		
						
					</div>
				</div>
			</section>

			<div class="container">
						<div class="row">
							<div class="col-sm-4" v-for="(actualData) in retrievedData" :key="actualData.id">
								<div class="profile-widget" >
																<div class="doc-img">
																	<router-link :to="'/schedule/courts/'+actualData.id" >
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
																
																	<ul class="available-info">
																		<li>
																			
																			<i class="fas fa-map-marker-alt"></i> {{club.address}} / {{ club.province==null ? '' : club.province.name}} , Moçambique
																		</li>
																		<li>
																			<i class="far fa-clock"></i> Disponivel todos dias
																		</li>
																		<li>
																			<i class="far fa-money-bill-alt"></i> {{club.min_price}} MT 
																			<i class="fas fa-info-circle" data-toggle="tooltip" ></i>
																		</li>
																	</ul>
																	<div class="row row-sm">
																		<div class="col-6">
																			<router-link :to="'/schedule/courts/'+actualData.id" class="btn view-btn">Ver detalhes</router-link>
																		</div>
																		<div class="col-6">
																			<router-link :to="'/schedule/courts/'+actualData.id" class="btn book-btn">Agendar</router-link>
																		</div>
																	</div>
																</div>
															</div>
							</div>

						
						</div>
						</div>
		
		   
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