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
let nextschedules = ref([]);
const loading = ref(false);
let users =ref([]);
let currentvalue = ref([]);
const toastr = useToastr();
let playersData = ref([]);
let systemUser = ref(1);
const loadingButtonDelete = ref(false);

let dataIdBeingDeleted = ref(null);
const schema = yup.object({

    
    // user_id: yup.string().required(),
   
  });



const getData = (page=1) => {
  axios.get(`/owner-schedules/+${router.currentRoute.value.params.id}?page=${page}`,
      {
        params:{
          query: searchQuery.value
        }
      })
       .then((response)=>{
        loadingDiv.value=false;
        retrievedData.value = response.data.schedule;
        playersData.value = response.data.playersData;
        nextschedules.value = response.data.nextschedules;
       
       }).catch(()=>{
        loadingDiv.value=false;
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
        console.log(response.data);
        users.value = response.data;
        // users.value = users.value.filter(data=>data.role_id !== 1 && data.role_id !== 2 ); 
 
       }).catch(()=>{
       })
}



const createRecordFunction = (values, actions) => {

 
currentvalue.value = {values};

loading.value = true;

const arr = Array.from(values)

axios.post('/owner-players',values).then((response)=>{

// categories.value.unshift(response.data);
// $('#createCategory').modal('hide');
retrievedData.value = response.data.schedule;
playersData.value = response.data.playersData;
nextschedules.value = response.data.nextschedules;
actions.resetForm();
// router.push({ path: '/owner/courts' });
toastr.success('Agendamento criado com sucesso');
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

const confirmDeletion = (data) => {

dataIdBeingDeleted = data.id;

$('#deleteModal').modal('show');
// axios.post('/categories',values).then((response)=>{

//   categories.value.unshift(response.data);
//   $('#createCategory').modal('hide');
//   resetForm();
// })
};

const deleteData = () =>{

loadingButtonDelete.value= true;

axios.delete(`/owner-players/${dataIdBeingDeleted}`)
.then((response)=>{
    // retrievedData.value = response.data.schedule;
    // retrievedData.value.data = retriviedData.value.data.filter(data=>data.id !== dataIdBeingDeleted); 
    retrievedData.value = response.data.schedule;
    playersData.value = response.data.playersData;
    nextschedules.value = response.data.nextschedules;
 $('#deleteModal').modal('hide');
 toastr.success('Registro apagado com sucesso');


}).catch((response)=>{
 toastr.error('Erro ao apagar. '+response.message);
 loadingButtonDelete.value= false;
 $('#deleteModal').modal('hide');
}).finally(()=>{
 loadingButtonDelete.value= false;
});
}

function goBackUsingBack() {
    if (router) {
        router.back();
    }
}

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
                                        <h5 class="card-title">Data: {{ moment(retrievedData.date).format('DD-MM-YYYY') }}</h5>

                                        <Button class="btn btn-pill btn-primary mt-3" @click="goBackUsingBack()"><vue-feather type="arrow-left"></vue-feather>Voltar</Button> 

                                       
								    </div>
                                    
                                    <div class="card-body">
                                          
                                        <div class="row">
                                            <div class="col-xl-12 col-xxl-12 d-flex">
                                                <div class="w-100">
                                                    <p>Data: {{ moment(retrievedData.date).format('DD-MM-YYYY') }}</p>
                                                    <p>Inicio: {{ retrievedData.start_time }}</p>
                                                    <p>Fim: {{ retrievedData.end_time }}</p>
                                                    <p>Quadra: {{ retrievedData.court.name }}</p>
                                                    <p>Preço: {{ retrievedData.price.name +'( '+retrievedData.price.price +retrievedData.price.coin.symbol+' )' }}</p>
                                                    <p>Estado : <span class="badge bg-success" v-if="retrievedData.status_id == 1">{{ retrievedData.status.name+'('+retrievedData.players_count+')' }}</span> <span class="badge bg-warning" v-if="retrievedData.status_id == 2">{{ retrievedData.status.name+'('+retrievedData.players_count+')' }}</span> <span class="badge bg-danger" v-if="retrievedData.status_id == 3">{{ retrievedData.status.name+'('+retrievedData.players_count+')' }}</span></p>

                                                    <hr>
                                                    <a class="btn btn-pill btn-primary mt-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                        <vue-feather type="plus"></vue-feather>Agendar
                                                    </a>
                                                    <div class="collapse mt-3" id="collapseExample">
                                                        <div class="card-body">
                                                            <Form @submit="createRecordFunction" :validation-schema="schema" v-slot="{ errors }">
                                                               

                                                                <div class="row">
                                                                    <div class="mb-3 col-md-12">
                                                                        <label class="form-label" for="user">Usuário do sistema?</label>
                                                                        <Field as="select" class="form-control" :class="{'is-invalid':errors.user}" name="system" v-model="systemUser" id="system">
                                                                            <option value="2">Sim</option>
                                                                            <option value="1">Não</option>
                                                                        </Field>
                                                                        
                                                                        <span class="invalid-feedback">{{ errors.user }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-12">
                                                                        <label class="form-label" for="user">Múltiplo Agendamento</label>
                                                                        <FieldArray class="form-control" name="multipleschedule">
                                                                            <div class="row">
                                                                                <div class="mb-2 col-md-3" v-for="(nextschedule,idx) in nextschedules" :key="nextschedule.id">
                                                                                    <Field class="form-check-input" type="checkbox" :value="nextschedule.id" :id="`multipleschedule[${idx}].multipleschedule_id`" :name="`multipleschedule[${idx}].multipleschedule_id`"/>
                                                                                    <span class="form-check-label">
                                                                                    {{ nextschedule.start_time }} / {{ nextschedule.end_time }}
                                                                                    
                                                                                        <span class="badge bg-success"
                                                                                            v-if="nextschedule.status_id == 1">{{
                                                                                                nextschedule.status.name +
                                                                                                "(" +
                                                                                                nextschedule.players_count +
                                                                                                ")"
                                                                                            }}
                                                                                        </span>
                                                                                        <span class="badge bg-warning"
                                                                                            v-if="nextschedule.status_id == 2">{{
                                                                                                nextschedule.status.name +
                                                                                                "(" +
                                                                                                nextschedule.players_count +
                                                                                                ")"
                                                                                            }}
                                                                                        </span>
                                                                                        <span class="badge bg-danger"
                                                                                            v-if="nextschedule.status_id == 3">{{
                                                                                                nextschedule.status.name +
                                                                                                "(" +
                                                                                                nextschedule.players_count +
                                                                                                ")"
                                                                                            }}
                                                                                        </span>
                                                                                    
                                                                                    </span> 
                                                                                </div>
                                                                            </div>  
                                                                        </FieldArray>
                                                                        
                                                                        <span class="invalid-feedback">{{ errors.user }}</span>
                                                                    </div>
                                                                </div>

                                                                <div v-if="systemUser == 1">
                                                                    <div class="row">
                                                                        <div class="mb-3 col-md-12">
                                                                            <label class="form-label" for="user">Nome</label>
                                                                            <Field type="text" class="form-control" :class="{'is-invalid':errors.user}" name="name" id="name" placeholder="Nome"/>
                                                                            <Field type="hidden" class="form-control" :class="{'is-invalid':errors.schedule_id}" name="schedule_id" v-model="retrievedData.id" id="schedule_id"/>
                                                                            <span class="invalid-feedback">{{ errors.user }}</span>
                                                                        </div>
                                                                        <div class="mb-3 col-md-12">
                                                                            <label class="form-label" for="email">Email</label>
                                                                            <Field type="text" class="form-control" :class="{'is-invalid':errors.email}" name="email" id="email" placeholder="Email"/>
                                                                            <span class="invalid-feedback">{{ errors.email }}</span>
                                                                        </div>
                                                                        <div class="mb-3 col-md-12">
                                                                            <label class="form-label" for="mobile">Telefone</label>
                                                                            <Field type="text" class="form-control" :class="{'is-invalid':errors.mobile}" name="mobile" id="mobile" placeholder="Telefone"/>
                                                                            <span class="invalid-feedback">{{ errors.user }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div v-if="systemUser == 2">
                                                                    <div class="row">
                                                                    <div class="mb-3 col-md-12">
                                                                        <label class="form-label" for="user">Procure pelo Nome, Email ou Telefone do Jogador</label>
                                                                        <Field type="text" class="form-control" :class="{'is-invalid':errors.user}" name="user" v-model="searchQuery" id="user" placeholder="Nome, Email ou Telefone"/>
                                                                        <Field type="hidden" class="form-control" :class="{'is-invalid':errors.schedule_id}" name="schedule_id" v-model="retrievedData.id" id="schedule_id"/>
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
                                                                    
                                                                    <th>Nome</th>
                                                                    <th>Telefone</th>
                                                                    <th>Email</th>
                                                                    <th>Observação</th>
                                                                    <th>Data da Reserva</th>
                                                                    <th>Transação</th>
                                                                    <th>Ações</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="playersData.data.length > 0">
                                                                <tr  v-for="(actualData,index) in playersData.data" :key="actualData.id">
                                                                    <td>#{{ index + 1 }}</td>
                                                                   
                                                                    <!-- <td>{{ actualData.user.name}} {{ actualData.user.surname}}</td> -->
                                                                    <td>{{ actualData.name != null ? actualData.name : actualData.user.name+' '+actualData.user.surname }}</td>
                                                                    <td>{{ actualData.mobile != null ? actualData.mobile :actualData.user.mobile}}</td>
                                                                    <td>{{ actualData.email != null ? actualData.email : actualData.user.email}}</td>
                                                                    <td>{{ actualData.obs}}</td>
                                                                    <td>{{ moment(actualData.created_at).format('DD-MM-YYYY H:mm')}}</td>
                                                                    <td>#{{ actualData.transaction == null ? '' : actualData.transaction.id}}</td>
                                                                    
                                                                    
                                                                    <td>
                                                                        <!-- <router-link :to="'/admin/schedules/'+actualData.id+'/edit'"><vue-feather type="edit-2"></vue-feather></router-link> -->
                                                                        <router-link :to="'/owner/schedules/'+actualData.id"><vue-feather type="eye"></vue-feather></router-link> 
                                                                        <a href="#" @click.prevent="confirmDeletion(actualData)"><vue-feather type="trash"></vue-feather></a>
                                                                        
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

    <div class="modal" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Deseja mesmo eliminar este item.</h5>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            Ao apagar este item, irá apagar todos os registros relacionados a ele.
        </div>
        <div class="modal-footer">
          
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button @click.prevent="deleteData" type="button" class="btn btn-danger" :disabled="loadingButtonDelete">
                    <div v-if="loadingButtonDelete" class="spinner-border spinner-border-sm" role="status"></div>
                    <span v-else>Apagar registro</span>
                </button>
         
          
        </div>
      </div>
    </div>
  </div>
</template>