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
  axios.get(`/owner-prices/+${router.currentRoute.value.params.id}?page=${page}`,
      {
        params:{
          query: searchQuery.value
        }
      })
       .then((response)=>{
        loadingDiv.value=false;
        retrievedData.value = response.data.price;
       
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

axios.post('/owner-prices',values).then((response)=>{

// categories.value.unshift(response.data);
// $('#createCategory').modal('hide');
scheduleData.value = response.data
actions.resetForm();
// router.push({ path: '/owner/courts' });
toastr.success('Preço criado com sucesso');
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

        <h1 class="h3 mb-3">Preços</h1>
        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Preço: {{ retrievedData.name }}</h5>

                                        <router-link to="/owner/prices" class="btn btn-pill btn-primary mt-3"><vue-feather type="arrow-left"></vue-feather>Voltar</router-link> 

                                       
								    </div>
                                    
                                    <div class="card-body">
                                          
                                        <div class="row">
                                            <div class="col-xl-12 col-xxl-12 d-flex">
                                                <div class="w-100">
                                                    <p>Nome da Preço: {{ retrievedData.name }}</p>
                                                    <p>Valor: {{ retrievedData.price }} {{ retrievedData.coin.symbol }}</p>
                                                    <p>Moeda: {{ retrievedData.coin.name }}</p>

                                                 
                                                
                                                  
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