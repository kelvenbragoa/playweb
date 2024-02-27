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
let loadingButtonSubmit =ref([false]);
let loadingDiv =ref([true]);
const toastr = useToastr();
const prices = ref([]);
const router = useRouter();
let self = this;
let currentvalue = ref([]);
const schema = yup.object({
  price_id: yup.string().required(),
});







const getData = () => {
  axios.get(`/owner-schedules/+${router.currentRoute.value.params.id}/edit`)
       .then((response)=>{

        loadingDiv.value=false;
        retrievedData.value = response.data.schedule;
        prices.value = response.data.prices;

       }).catch(()=>{

        loadingDiv.value=false;

       })
}

const editFunction = (values, actions) => {

  loadingButtonSubmit.value = true;
  axios.patch(`/owner-schedules/${retrievedData.value.id}`,values).then((response)=>{

    // admins.value.unshift(response.data);
    // $('#createCategory').modal('hide');
    actions.resetForm();
    router.push({ path: `/owner/courts/${retrievedData.value.court_id}`});
    toastr.success('Registro editada com sucesso');

  }).catch((error)=>{

    loadingButtonSubmit.value = false;
    toastr.error('Erro ao adicionar');
    if(error.response.data.errors){
      actions.setErrors(error.response.data.errors);
    }
  }).finally(()=>{
    loadingButtonSubmit.value = false;
  })
};




onMounted(()=>{
  getData();
})
</script>

<template>
    <div v-if="!loadingDiv">

        <h1 class="h3 mb-3">Horários</h1>
        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Horário: {{ retrievedData.name }}</h5>

                                        <router-link :to="'/owner/courts/'+retrievedData.court_id" class="btn btn-pill btn-primary mt-3"><vue-feather type="arrow-left"></vue-feather>Voltar</router-link> 

                                       
								    </div>
                                    
                                    <div class="card-body">
                                          
                                        <div class="row">
                                            <div class="col-xl-12 col-xxl-12 d-flex">
                                                <div class="w-100">
                                                    <Form @submit="editFunction" :validation-schema="schema" v-slot="{ errors }">
                                                    
                                                        <div class="row">
                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label" for="date">Data</label>
                                                                <Field type="text" class="form-control" :class="{'is-invalid':errors.date}" name="date" v-model="retrievedData.date" id="date" placeholder="Data" readonly/>
                                                                <span class="invalid-feedback">{{ errors.date }}</span>
                                                            </div>
                                                        </div>
												
                                                        <div class="row">
                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label" for="start_time">Inicio</label>
                                                                <Field type="text" class="form-control" :class="{'is-invalid':errors.start_time}" name="start_time" v-model="retrievedData.start_time" id="start_time" placeholder="Horas" readonly/>
                                                                <span class="invalid-feedback">{{ errors.start_time }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label" for="end_time">Fim</label>
                                                                <Field type="text" class="form-control" :class="{'is-invalid':errors.end_time}" name="end_time" v-model="retrievedData.end_time" id="end_time" placeholder="Horas" readonly/>
                                                                <span class="invalid-feedback">{{ errors.end_time }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label" for="price_id">Preço</label>
                                                                <Field as="select" class="form-control"
                                                                    :class="{ 'is-invalid': errors.price_id }" name="price_id"
                                                                    id="price_id" aria-describedby="price_id" v-model="retrievedData.price_id">
                                                                    <option value="" disabled>Selecionar</option>
                                                                    <option v-for="price in prices" :key="price.id"
                                                                        :value="price.id">
                                                                        {{ price.name }}
                                                                    </option>
                                                                </Field>
                                                                <span class="invalid-feedback">{{
                                                                    errors.price_id
                                                                }}</span>
                                                            </div>
                                                        </div>
												
                                                        <button type="submit" class="btn btn-primary" :disabled="loadingButtonSubmit == true">
                                                            <div v-if="loadingButtonSubmit == true" class="spinner-border spinner-border-sm" role="status"></div>
                                                            <span v-else>Submeter</span>
                                                        </button>


                                                    </Form>
                                                    
                                            
                                                
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