<script setup>

import axios from 'axios';
import { ref, onMounted, reactive, defineEmits, defineComponent,watch } from "vue";
import moment from 'moment'
import {useToastr} from '../../../toastr';
import {debounce} from 'lodash';
import {Form, Field} from 'vee-validate';
import { useRouter} from "vue-router";
import * as yup from 'yup';
import VueFeather from 'vue-feather';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';

let retrievedData =ref([]);
let scheduleData = ref([])
let loadingSubmit =ref([true]);
let loadingDiv =ref([true]);
const router = useRouter();
let self = this;
let searchQuery = ref(null)
let equipments = ref([]);
const loading = ref(false);
let prices =ref([]);
let currentvalue = ref([]);
const toastr = useToastr();
const schema = yup.object({

    
    date: yup.string().required(),
   
  });



const getData = (page=1) => {
  axios.get(`/owner-courts/+${router.currentRoute.value.params.id}?page=${page}`,
      {
        params:{
          query: searchQuery.value
        }
      })
       .then((response)=>{
        loadingDiv.value=false;
        retrievedData.value = response.data.court;
        scheduleData.value = response.data.schedule;
        prices.value = response.data.prices;
       }).catch(()=>{
        loadingDiv.value=false;
       })
}


watch(searchQuery,debounce(()=>{
    getData();
},300));

const createRecordFunction = (values, actions) => {

 
currentvalue.value = {values};

loading.value = true;

const arr = Array.from(values)

axios.post('/owner-schedules',values).then((response)=>{

// categories.value.unshift(response.data);
// $('#createCategory').modal('hide');
scheduleData.value = response.data
actions.resetForm();
// router.push({ path: '/owner/courts' });
toastr.success('Horario criado com sucesso');
}).catch((error)=>{

loading.value = false;
toastr.error('Erro ao adicionar. '+error.response.data.message);
if(error.response.data.errors){
   
    actions.setErrors(error.response.data.errors);
}
}).finally(()=>{
loading.value = false;

})



};

onMounted(()=>{
  
  getData();
})
</script>

<template>
    <div v-if="!loadingDiv">

        <h1 class="h3 mb-3">Quadra</h1>
        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Quadra: {{ retrievedData.name }}</h5>

                                        <router-link to="/owner/courts" class="btn btn-pill btn-primary mt-3"><vue-feather type="arrow-left"></vue-feather>Voltar</router-link> 

                                       
								    </div>
                                    
                                    <div class="card-body">
                                          
                                        <div class="row">
                                            <div class="col-xl-12 col-xxl-12 d-flex">
                                                <div class="w-100">
                                                    <p>Nome da Quadra: {{ retrievedData.name }}</p>
                                                    <p>Limite: {{ retrievedData.limit }}</p>
                                                    <p>Descrição: {{ retrievedData.description }}</p>

                                                    <hr>
                                                    <a class="btn btn-pill btn-primary mt-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                        <vue-feather type="plus"></vue-feather>Adicionar Horario
                                                    </a>
                                                    <div class="collapse mt-3" id="collapseExample">
                                                        <div class="card-body">
                                            <Form @submit="createRecordFunction" :validation-schema="schema" v-slot="{ errors }">
												<div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="name">Data</label>
														<Field type="date" class="form-control" :class="{'is-invalid':errors.date}" name="date" id="date" placeholder="Data"/>
                                                        <Field type="hidden" class="form-control" :class="{'is-invalid':errors.court_id}" name="court_id" id="date" v-model="retrievedData.id" placeholder="Data"/>
                                                        <span class="invalid-feedback">{{ errors.date }}</span>
													</div>
												</div>

                                                <div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="start_time">Horas de Inicio</label>
														<Field type="time" class="form-control" :class="{'is-invalid':errors.date}" name="start_time" id="start_time" placeholder="Horas de inicio"/>
                                                        <span class="invalid-feedback">{{ errors.start_time }}</span>
													</div>
												</div>

                                                <div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="end_time">Horas de Fim</label>
														<Field type="time" class="form-control" :class="{'is-invalid':errors.end_time}" name="end_time" id="end_time" placeholder="Horas de Fim"/>
                                                        <span class="invalid-feedback">{{ errors.end_time }}</span>
													</div>
												</div>

    

                                                <div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="price_id">Preço</label>
														<Field as="select" class="form-control" :class="{'is-invalid':errors.price_id}"  name="price_id" id="price_id" aria-describedby="price_id">
                                                            <option value="" disabled>Selecionar</option>
                                                            <option v-for="price in prices" :key="price.id" :value="price.id">{{ price.name }}</option>
                                                        </Field>
                                                        <span class="invalid-feedback">{{ errors.price_id }}</span>
													</div>
												</div>
												

                                                

                                                
                                               
												<button type="submit" class="btn btn-primary" :disabled="loading">
                                                    <div v-if="loading" class="spinner-border spinner-border-sm" role="status"></div>
                                                    <span v-else>Submeter</span>
                                                </button>
											</Form>

										</div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Quadra</th>
                                                                    <th>Data</th>
                                                                    <th>Inicio</th>
                                                                    <th>Fim</th>
                                                                    <th>Preço</th>
                                                                    <th>Estado</th>
                                                                    <th>Ações</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="scheduleData.data.length > 0">
                                                                <tr  v-for="(actualData,index) in scheduleData.data" :key="actualData.id">
                                                                    <td>#{{ index + 1 }}</td>
                                                                    <td>{{ actualData.court.name}}</td>
                                                                    <td>{{ actualData.date}}</td>
                                                                    <td>{{ actualData.start_time}}</td>
                                                                    <td>{{ actualData.end_time}}</td>
                                                                    <td>{{ actualData.price.name}}</td>
                                                                    <td><span class="badge bg-success" v-if="actualData.status_id == 1">{{ actualData.status.name }}</span> <span class="badge bg-warning" v-if="actualData.status_id == 2">{{ actualData.status.name }}</span> <span class="badge bg-danger" v-if="actualData.status_id == 3">{{ actualData.status.name }}</span> </td>
                                                                    
                                                                    <td>
                                                                        <!-- <router-link :to="'/admin/schedules/'+actualData.id+'/edit'"><vue-feather type="edit-2"></vue-feather></router-link> -->
                                                                        <router-link :to="'/admin/schedules/'+actualData.id"><vue-feather type="eye"></vue-feather></router-link> 
                                                                        <!-- <a href="#" @click.prevent="confirmDeletion(actualData)"><vue-feather type="trash"></vue-feather></a> -->
                                                                        
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody v-else>
                                                                <tr>
                                                                <td colspan="9" align="center">Nenhum resultado encontrado</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <Bootstrap4Pagination :data="scheduleData" @pagination-change-page="getData"/>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								</div>
                            </div>   
                        </div>
                    </div>
    <div v-else>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    Carregando Dados...
                </div>
            </div> 
        </div>
    </div>
</template>