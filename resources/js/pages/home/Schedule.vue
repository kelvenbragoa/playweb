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
const court = ref([])
const dates = ref([])
const schedule = ref([])
let dataIdBeingDeleted = ref(null);



const getData = async () => {
  axios.get(`/home-schedule-court/${router.currentRoute.value.params.id}`, 
  {
        params:{
          query: searchQuery.value
        }
      })
       .then((response)=>{
        loadingDiv.value=false;
        retrievedData.value = response.data.schedule;
		dates.value = response.data.dates;
        court.value = response.data.court;
     
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
		<!-- Breadcrumb -->
		<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Agendamento</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Agendar</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
		<div v-if="!loadingDiv">

	
    
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">
				
					<div class="row">
						<div class="col-12">
						
							<div class="card">
								<div class="card-body">
									<div class="booking-doc-info">
										<a href="#" class="booking-doc-img">
											<img src="/letsplay.png">
										</a>
										<div class="booking-info">
											<h4><router-link :to="'/clubs/'+court.club_id">{{court.name}}</router-link></h4>
											<h4><router-link :to="'/clubs/'+court.club_id">{{court.description}}</router-link></h4>
											
											<p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> {{court.club.province.name}}, Moçambique</p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Schedule Widget -->
							<div class="card booking-schedule schedule-widget">
							
								<!-- Schedule Header -->
								<div class="schedule-header">
									<div class="row">
										<div class="col-md-12">
										
											<!-- Day Slot -->
											<div class="day-slot">
												<ul>
													<!-- <li class="left-arrow">
														<a href="#">
															<i class="fa fa-chevron-left"></i>
														</a>
													</li> -->
													<li v-for="(date) in dates" :key="date.id">
														<span>{{moment(date).format('dd')}}</span>
														<span class="slot-date">{{moment(date).format('D MMM')}} <small class="slot-year">{{moment(date).format('Y')}}</small></span>
													</li>
													
												</ul>
											</div>
											<!-- /Day Slot -->
											
										</div>
									</div>
								</div>
								<!-- /Schedule Header -->
								
								<!-- Schedule Content -->
								<div class="schedule-cont">
									<div class="row">
										<div class="col-md-12">
										
											<!-- Time Slot -->
											<div class="time-slot">
												<ul class="clearfix">
													<li v-for="(schedule) in retrievedData" :key="schedule.id" >
														<a class="timing bg-success" href="#" v-if="schedule.status_id==1">
															<span>{{ schedule.start_time}}</span> <br> to <br> <span>{{schedule.end_time }}</span> 
														</a>
														<a class="timing bg-warning" href="#" v-if="schedule.status_id==2">
															<span>{{ schedule.start_time}}</span> <br> to <br> <span>{{schedule.end_time }}</span> 
														</a>
														<a class="timing bg-danger" href="#" v-if="schedule.status_id==3">
															<span>{{ schedule.start_time}}</span> <br> to <br> <span>{{schedule.end_time }}</span> 
														</a>
													</li>
													
												</ul>
											</div>
											<!-- /Time Slot -->
											
										</div>
									</div>
								</div>
								<!-- /Schedule Content -->
								
							</div>
							<!-- /Schedule Widget -->
							
							<!-- Submit Section -->
							<div class="submit-section proceed-btn text-right">
								<a href="checkout.html" class="btn btn-primary submit-btn">Proceder</a>
							</div>
							<!-- /Submit Section -->
							
						</div>
					</div>
				</div>

			</div>		
			<!-- /Page Content -->
		   
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