<script setup>

import {onMounted, ref, reactive,watch} from 'vue';
import axios from 'axios';
import {useToastr} from '../../../toastr';
import {Form, Field} from 'vee-validate';
import * as yup from 'yup';
import { useRouter } from "vue-router";
import moment from 'moment'
import {debounce} from 'lodash';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import VueFeather from 'vue-feather';

const loading = ref(false);
const toastr = useToastr();
const loadingDiv = ref(true);
let currentvalue = ref([]);
let courts =ref([]);
let prices =ref([]);
const schema = yup.object({
    
  date: yup.string().required(),
 
});
let self = this;
const router = useRouter();

const createRecordFunction = (values, actions) => {

 
    currentvalue.value = {values};

    loading.value = true;

    const arr = Array.from(values)
    
    axios.post('/schedules',values).then((response)=>{

    // categories.value.unshift(response.data);
    // $('#createCategory').modal('hide');
    actions.resetForm();
    router.push({ path: '/admin/schedules' });
    toastr.success('Área criada com sucesso');
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

const getAuxiliarData = () => {

axios.get('/auxiliar-create-schedule')
     .then((response)=>{

      prices.value = response.data.prices;
      courts.value = response.data.courts;

      loadingDiv.value=false;

     


     })
     .catch((error)=>{
      toastr.error(error);
      router.push({ path: '/admin/users' });
     })
}


onMounted(()=>{
    getAuxiliarData()
})

</script>

<template>
    <div v-if="!loadingDiv">
        <h1 class="h3 mb-3">Horarios</h1>
        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Formulário criação das Horarios do sistema.</h5>

                                        <router-link to="/admin/schedules" class="btn btn-pill btn-primary mt-3"><vue-feather type="arrow-left"></vue-feather>Voltar</router-link> 

                                       
								    </div>
                                    
                                    <div class="card-body">
                                            <Form @submit="createRecordFunction" :validation-schema="schema" v-slot="{ errors }">
												<div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="name">Data</label>
														<Field type="date" class="form-control" :class="{'is-invalid':errors.date}" name="date" id="date" placeholder="Data"/>
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
														<label class="form-label" for="court_id">Quadra</label>
														<Field as="select" class="form-control" :class="{'is-invalid':errors.court_id}"  name="court_id" id="court_id" aria-describedby="court_id">
                                                            <option value="" disabled>Selecionar</option>
                                                            <option v-for="court in courts" :key="court.id" :value="court.id">{{ court.name }}</option>
                                                        </Field>
                                                        <span class="invalid-feedback">{{ errors.court_id }}</span>
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