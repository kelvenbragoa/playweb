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

    
    old_password: yup.string().required(),
    new_password:yup.string().min(6).required(),
    new_password_confirmation: yup
        .string()
        .oneOf([yup.ref('new_password')], 'Passwords must match')
        .required()
        .label('Password confirmation')
    
   
  });



const getData = (page=1) => {
  axios.get(`/owner-profile`,
      {
        params:{
          query: searchQuery.value
        }
      })
       .then((response)=>{
        loadingDiv.value=false;
        retrievedData.value = response.data;
       
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

axios.post('/owner-profile',values).then((response)=>{

// categories.value.unshift(response.data);
// $('#createCategory').modal('hide');
// scheduleData.value = response.data
actions.resetForm();
// router.push({ path: '/owner/courts' });
toastr.success('Password alterado com sucesso');
}).catch((error)=>{

loading.value = false;
toastr.error('Erro ao alterar a password. '+error.response.data.message);
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

        <h1 class="h3 mb-3">Perfil</h1>
        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                       

                                       
								    </div>
                                    
                                    <div class="card-body">
                                          
                                        <div class="row">
                                            <div class="col-xl-12 col-xxl-12 d-flex">
                                                <div class="w-100">
                                                    <!-- <p>Nome da Preço: {{ retrievedData.name }}</p>
                                                    <p>Valor: {{ retrievedData.price }} {{ retrievedData.coin.symbol }}</p>
                                                    <p>Moeda: {{ retrievedData.coin.name }}</p> -->

                                                    <h5 class="card-title mb-0">Informações do usuario</h5>
                                                    
                                                    <form>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="inputFirstName">Email</label>
                                                                <input type="text" readonly class="form-control" id="inputFirstName" :value="retrievedData.email">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="inputFirstName">Nome</label>
                                                                <input type="text" readonly class="form-control" id="inputFirstName" :value="retrievedData.name">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="inputFirstName">Apelido</label>
                                                                <input type="text" readonly class="form-control" id="inputFirstName" :value="retrievedData.surname">
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <h5 class="card-title mb-0">Alterar palavra passe</h5>
                                                    <Form @submit="createRecordFunction" :validation-schema="schema" v-slot="{ errors }">

                                                            <div class="row">
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label" for="inputFirstName">Palavra passe antiga</label>
                                                                        <Field type="password" class="form-control" :class="{'is-invalid':errors.old_password}" name="old_password" id="old_password"/>
                                                                        <span class="invalid-feedback">{{ errors.old_password }}</span>                                                                    </div>
                                                            </div>
                                                            <div class="row">
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label" for="inputFirstName">Nova palavra passe</label>
                                                                        <Field type="password" class="form-control" :class="{'is-invalid':errors.new_password}" name="new_password" id="new_password"/>
                                                                        <span class="invalid-feedback">{{ errors.new_password }}</span>
                                                                    </div>
                                                            </div>
                                                            <div class="row">
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label" for="inputFirstName">Confirmar Nova palavra passe</label>
                                                                        <Field type="password" class="form-control" :class="{'is-invalid':errors.new_password_confirmation}" name="new_password_confirmation" id="new_password_confirmation"/>
                                                                        <span class="invalid-feedback">{{ errors.new_password_confirmation }}</span>
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