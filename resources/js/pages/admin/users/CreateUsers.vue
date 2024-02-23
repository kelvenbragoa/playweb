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
let roles =ref([]);
let areas =ref([]);
let destinations =ref([]);
let currentvalue = ref([]);
let provinces =ref([]);
let cities =ref([]);
let user_statuses =ref([]);
let account_statuses =ref([]);
const loadingDiv = ref(true);
const province_id_to_city = ref(0);
const user_role = ref(0);

const schema = yup.object({
    
  name: yup.string().required(),
  surname: yup.string().required(),
  email: yup.string().email().required(),
  password: yup.string().required().min(8),
  address: yup.string().required(),
  
});
let self = this;
const router = useRouter();

const createRecordFunction = (values, actions) => {


    currentvalue.value = {values};

    loading.value = true;

    const arr = Array.from(values)

    console.log(arr)
    console.log(values)
    
    axios.post('/users',values).then((response)=>{

    // categories.value.unshift(response.data);
    // $('#createCategory').modal('hide');
    actions.resetForm();
    router.push({ path: '/admin/users' });
    toastr.success('Usuário criado com sucesso');
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

        roles.value = response.data.roles;
        areas.value = response.data.areas;
        destinations.value = response.data.destinations;
        provinces.value = response.data.provinces;
        user_statuses.value = response.data.user_statuses;
        account_statuses.value = response.data.account_statuses;
        loadingDiv.value=false;

       


       })
       .catch((error)=>{
        toastr.error(error);
        router.push({ path: '/admin/users' });
       })
}

const getCity = (city) => {

    axios.get(`/auxiliar-create-users/${city}`)
       .then((response)=>{

        cities.value = response.data.cities;
       })
       .catch((error)=>{
        toastr.error(error);
        router.push({ path: '/admin/users' });
       })
}

// const formobjective = reactive([
//     {id: ''}
// ]);
// const addRow = () =>{
//     formobjective.push({id:''})
// }
// const removeRow = (index) =>{
//     if(formobjective.length>1){
//         formobjective.splice(index,1)
//     }
    
// }

onMounted(()=>{
    getAuxiliarData()
})
</script>

<template>
    <div v-if="!loadingDiv">
        <h1 class="h3 mb-3">Usuários</h1>
        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Formulário criação dos usuários do sistema.</h5>

                                        <router-link to="/admin/users" class="btn btn-pill btn-primary mt-3"><vue-feather type="arrow-left"></vue-feather>Voltar</router-link> 

                                       
								    </div>
                                    
                                    <div class="card-body">
                                            <Form @submit="createRecordFunction" :validation-schema="schema" v-slot="{ errors }">
												<div class="row">
													<div class="mb-3 col-md-6">
														<label class="form-label" for="name">Primeiro Nome</label>
														<Field type="text" class="form-control" :class="{'is-invalid':errors.name}" name="name" id="name" placeholder="Primeiro Nome"/>
                                                        <span class="invalid-feedback">{{ errors.name }}</span>
													</div>
													<div class="mb-3 col-md-6">
														<label class="form-label" for="surname">Apelido</label>
														<Field type="text" class="form-control" :class="{'is-invalid':errors.surname}" name="surname" id="surname" placeholder="Apelido"/>
                                                        <span class="invalid-feedback">{{ errors.surname }}</span>
													</div>
												</div>
                                                <div class="row">
                                                    <div class="mb-3">
													<label class="form-label" for="email">Email</label>
													<Field type="email" class="form-control"  :class="{'is-invalid':errors.email}" name="email" id="email" placeholder="Email"/>
                                                    <span class="invalid-feedback">{{ errors.email }}</span>
												</div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3">
													<label class="form-label" for="password">Palavra passe</label>
													<Field type="password" class="form-control"  :class="{'is-invalid':errors.password}" name="password" id="password" placeholder="Palavra passe"/>
                                                    <span class="invalid-feedback">{{ errors.password }}</span>
												</div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3">
													<label class="form-label" for="birth_date">Data Nascimento</label>
													<Field type="date" class="form-control" id="birth_date" :class="{'is-invalid':errors.birth_date}" name="birth_date"  placeholder="Data Nascimento"/>
                                                    <span class="invalid-feedback">{{ errors.birth_date }}</span>
												</div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3">
													<label class="form-label" for="mobile">Telefone</label>
													<Field type="text" class="form-control" id="mobile" :class="{'is-invalid':errors.mobile}" name="mobile"  placeholder="Data Nascimento"/>
                                                    <span class="invalid-feedback">{{ errors.mobile }}</span>
												</div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3">
													<label class="form-label" for="gender_id">Sexo</label>
													<Field as="select" class="form-control" :class="{'is-invalid':errors.gender_id}" name="gender_id" id="gender_id" placeholder="Sexo">
                                                        <option value="1">Masculino</option>
                                                        <option value="2">Feminino</option>
                                                    </Field>
                                                    <span class="invalid-feedback">{{ errors.gender_id }}</span>
												</div>
                                                </div>
                                                <hr>

												<div class="row">
                                                    <div class="mb-3 col-md-6">
														<label class="form-label" for="club_name">Nome Clube</label>
														<Field type="text" class="form-control" :class="{'is-invalid':errors.club_name}" name="club_name" id="club_name" placeholder="Nome Clube"/>
                                                        <span class="invalid-feedback">{{ errors.club_name }}</span>
													</div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
														<label class="form-label" for="image_url">Imagem Clube</label>
														<Field type="text" class="form-control" :class="{'is-invalid':errors.image_url}" name="image_url" id="image_url" placeholder="Image URL"/>
                                                        <span class="invalid-feedback">{{ errors.image_url }}</span>
													</div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
														<label class="form-label" for="address">Endereço</label>
														<Field type="text" class="form-control" :class="{'is-invalid':errors.address}" name="address" id="address" placeholder="Endereço"/>
                                                        <span class="invalid-feedback">{{ errors.address }}</span>
													</div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
														<label class="form-label" for="description">Descrição</label>
														<Field type="text" class="form-control" :class="{'is-invalid':errors.description}" name="description" id="description" placeholder="Descrição"/>
                                                        <span class="invalid-feedback">{{ errors.description }}</span>
													</div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
														<label class="form-label" for="min_price">Preço Mínimo</label>
														<Field type="number" class="form-control" :class="{'is-invalid':errors.min_price}" name="min_price" id="min_price" placeholder="Preço minino"/>
                                                        <span class="invalid-feedback">{{ errors.min_price }}</span>
													</div>
                                                </div>
                                                <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="province_id">Província</label>
                                                                <Field as="select" class="form-control" :class="{'is-invalid':errors.province_id}"  name="province_id" id="province_id" aria-describedby="province_id">
                                                                    <option value="" disabled>Selecionar</option>
                                                                    <option v-for="province in provinces" :key="province.id" :value="province.id">{{ province.name }}</option>
                                                                </Field>
                                                                <span class="invalid-feedback">{{ errors.province_id }}</span>

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