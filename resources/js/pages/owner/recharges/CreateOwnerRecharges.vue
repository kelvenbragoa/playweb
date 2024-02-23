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
let coins =ref([]);
let searchQuery = ref(null)
let users =ref([]);
const schema = yup.object({
    
  user_id: yup.string().required(),
//   address: yup.string().required(),
  price: yup.number().required(),
//   description: yup.string().required(),
//   province_id: yup.string().required(),
 
});
let self = this;
const router = useRouter();

const createRecordFunction = (values, actions) => {

 
    currentvalue.value = {values};

    loading.value = true;

    const arr = Array.from(values)
    
    axios.post('/owner-recharges',values).then((response)=>{

    // categories.value.unshift(response.data);
    // $('#createCategory').modal('hide');
    actions.resetForm();
    router.push({ path: '/owner/recharges' });
    toastr.success('Registro criado com sucesso');
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

      coins.value = response.data.coins;
      

      loadingDiv.value=false;

     


     })
     .catch((error)=>{
      toastr.error(error);
      router.push({ path: '/owner/recharges' });
     })
}

watch(searchQuery,debounce(()=>{
    getUsers();
},300));

const getUsers = () => {
  axios.get(`/owner-search-users`,
      {
        params:{
          query: searchQuery.value
        }
      })
       .then((response)=>{
        users.value = response.data;
       
       }).catch(()=>{
       })
}

onMounted(()=>{
    getAuxiliarData()
})

</script>

<template>
    <div v-if="!loadingDiv">
        <h1 class="h3 mb-3">Recargas</h1>
        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Formulário criação dos Recargas do sistema.</h5>

                                        <router-link to="/owner/recharges" class="btn btn-pill btn-primary mt-3"><vue-feather type="arrow-left"></vue-feather>Voltar</router-link> 

                                       
								    </div>
                                    
                                    <div class="card-body">
                                            <Form @submit="createRecordFunction" :validation-schema="schema" v-slot="{ errors }">

                                                <div class="row">
                                                                    <div class="mb-3 col-md-12">
                                                                        <label class="form-label" for="user">Procure pelo Nome, Email ou Telefone do Jogador</label>
                                                                        <Field type="text" class="form-control" :class="{'is-invalid':errors.user}" name="user" v-model="searchQuery" id="user" placeholder="Nome, Email ou Telefone"/>
                                                                        
                                                                        <span class="invalid-feedback">{{ errors.user }}</span>
                                                                    </div>
                                                                </div>

                                                <div class="row">
                                                                    <div class="mb-3 col-md-12">
                                                                        <label class="form-label" for="user_id">Jogador</label>
                                                                        <label class="form-label" for="user_id">Resultados: {{ users.length }}</label>
                                                                        <Field as="select" class="form-control" :class="{'is-invalid':errors.user_id}"  name="user_id" id="user_id" aria-describedby="user_id">
                                                                            <option value="" disabled>Selecionar</option>
                                                                            <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }} {{ user.surname }} - {{ user.mobile }} - {{ user.email }}</option>
                                                                        </Field>
                                                                        <span class="invalid-feedback">{{ errors.user_id }}</span>
                                                                    </div>
                                                                </div>
												<div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="name">Referencia</label>
														<Field type="text" class="form-control" :class="{'is-invalid':errors.ref}" name="ref" id="ref" placeholder="Referencia"/>
                                                        <span class="invalid-feedback">{{ errors.ref }}</span>
													</div>
												</div>

                                                <div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="name">Método</label>
														<Field type="text" class="form-control" :class="{'is-invalid':errors.ref}" name="method" id="method" placeholder="Método"/>
                                                        <span class="invalid-feedback">{{ errors.method }}</span>
													</div>
												</div>

                                                <div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="price">Valor</label>
														<Field type="number" class="form-control" :class="{'is-invalid':errors.price}" name="price" id="price" placeholder="Valor"/>
                                                        <span class="invalid-feedback">{{ errors.price }}</span>
													</div>
												</div>

                                                <!-- <div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="address">Endereço</label>
														<Field type="text" class="form-control" :class="{'is-invalid':errors.address}" name="address" id="address" placeholder="Endereço"/>
                                                        <span class="invalid-feedback">{{ errors.address }}</span>
													</div>
												</div> -->
                                                <!-- <div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="description">Descrição</label>
														<Field type="text" class="form-control" :class="{'is-invalid':errors.description}" name="description" id="description" placeholder="Endereço"/>
                                                        <span class="invalid-feedback">{{ errors.description }}</span>
													</div>
												</div> -->

                                                <!-- <div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="min_price">Preço Minimo</label>
														<Field type="number" class="form-control" :class="{'is-invalid':errors.min_price}" name="min_price" id="min_price" placeholder="Preço Minino"/>
                                                        <span class="invalid-feedback">{{ errors.min_price }}</span>
													</div>
												</div>
                                                <div class="row">
													<div class="mb-3 col-md-12">
														<label class="form-label" for="province_id">Província</label>
														<Field as="select" class="form-control" :class="{'is-invalid':errors.province_id}"  name="province_id" id="province_id" aria-describedby="province_id">
                                                            <option value="" disabled>Selecionar</option>
                                                            <option v-for="province in coins" :key="province.id" :value="province.id">{{ province.name }}</option>
                                                        </Field>
                                                        <span class="invalid-feedback">{{ errors.province_id }}</span>
													</div>
												</div>
												 -->

                                                

                                                
                                               
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