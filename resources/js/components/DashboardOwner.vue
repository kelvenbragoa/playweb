<script setup>

import {onMounted, ref, reactive, onUpdated,watch} from 'vue';
import axios from 'axios';
import VueFeather from 'vue-feather';
import moment from 'moment'
import {Field} from 'vee-validate';
import VCalendar from "v-calendar";
import { Calendar, DatePicker } from "v-calendar";


const loadingDiv = ref(true);
const users = ref(0)
const courts = ref(0)
const schedules = ref(0)
const selectedDate = ref(moment().format('YYYY-MM-DD'));
const courtData = ref([])
const scheduleGroup = ref([])

const actualcourt = ref()
const listcourt = ref([])
const actualid = ref(0)

// const centercosts = ref(0)
// const typeequipments = ref(0)
// const malfunctions = ref(0)
// const suppliers = ref(0)
// const tasks = ref(0)
// const equipments = ref(0)
// const mcscr = ref(0)



const getDashboardData = () =>{
    axios.get('/admins/dashboard/getdashboarddata')
    .then((response)=>{
        users.value = response.data.users
        courts.value = response.data.courtsowner
        schedules.value = response.data.schedulesowner
        courtData.value = response.data.courtData
        scheduleGroup.value = response.data.dategroup
        actualcourt.value = response.data.actualcourt
        listcourt.value = response.data.listcourt
        actualid.value = actualcourt.value.id
        // centercosts.value = response.data.centercosts
        // typeequipments.value = response.data.typeequipments
        // malfunctions.value = response.data.malfunctions
        // suppliers.value = response.data.suppliers
        // tasks.value = response.data.tasks
        // equipments.value = response.data.equipments
        // mcscr.value = response.data.mcscr
        loadingDiv.value=false;
    })
}

const getScheduleDate = (id)=>{
    axios.get(`/updateownerdashboard/+${id}`)
    .then((response)=>{
        actualcourt.value = response.data.actualcourt
        scheduleGroup.value = response.data.dategroup
    })}

watch(selectedDate, () => {
    // loadingBody.value = true;
    var newDate = moment(selectedDate.value).format("Y-MM-D");
    // alert(newDate)

    axios
        .get(
            `/updatescheduledashboard/${newDate}`
        )
        .then((response) => {
            courtData.value = response.data
            // retrievedData.value = response.data.court;
            // scheduleData.value = response.data.schedule;
            // prices.value = response.data.prices;
            // loadingBody.value = false;
        
        })
        .catch(() => {
            // loadingBody.value = false;
        });
    // loadingBody.value = false;
});



onMounted(()=>{
    getDashboardData();
})





</script>


<template>

    <div v-if="!loadingDiv">
        <h1 class="h3 mb-3">Dashboard Clube</h1>
        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Dashboard</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col mt-0">
                                                                <h5 class="card-title">Quadras</h5>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="stat text-primary">
                                                                    <vue-feather type="square"></vue-feather>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h1 class="mt-1 mb-3">{{courts}}</h1>
                                                        <div class="mb-0">
                                                             <router-link to=""><vue-feather type="eye"></vue-feather></router-link>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col mt-0">
                                                                <h5 class="card-title">Reservas para hoje <small>{{ moment().format('DD-MM-YYYY') }}</small></h5>
                                                                
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="stat text-primary">
                                                                    <vue-feather type="codepen"></vue-feather>
                                                           
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h1 class="mt-1 mb-3">{{schedules}}</h1>
                                                        <div class="mb-0">
                                                             <router-link to=""><vue-feather type="eye"></vue-feather></router-link>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <hr>
                                        <h5 class="card-title mb-0">Visão Semanal de Reservas</h5>
                                        <div class="row">
                                            <div class="col-12 col-lg-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5 class="card-title">{{ actualcourt.name }} </h5>
                                                                    <div class="row">
                                                                        <div class="mb-3 col-md-2">
                                                                            <label class="form-label" for="province_id">Escolher Quadra</label>
                                                                            <select class="form-control" v-model="actualid"  @change="getScheduleDate(actualid)" name="court">
                                                                                <option v-for="list in listcourt" :key="list.id" :value="list.id">{{ list.name }}</option>
                                                                            </select>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <!-- CADA LINHA -->
                                                                    
                                                                    <div class="row">

                                                                        <div class="col-12 col-md-2 text-white" v-for="group in scheduleGroup" :key="group.id">
                                                                            <div class="bg-secondary rounded text-center">
                                                                                <p>{{moment(group[0].date).format('DD-MM-YYYY')}}</p>
                                                                                <p>{{moment(group[0].date).format('dddd')}}</p>
                                                                            </div>
                                                                            <!-- Reservas -->
                                                                            <div class="row bg-secondary rounded text-white text-center mb-1 mr-1" v-for="schedule in group" :key="schedule.id" >
                                                                                <router-link  :to="'/owner/schedules/' + schedule.id" style="text-decoration: none; color: inherit;">
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                            {{schedule.start_time}}
                                                                                        </div>
                                                                                        <div class="col">
                                                                                            {{schedule.end_time}}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                            Reservas:
                                                                                        </div>
                                                                                        <div class="col">
                                                                                            <span class="rounded-circle p-1" :class="{'bg-success':schedule.status_id==1, 'bg-warning':schedule.status_id==2, 'bg-danger':schedule.status_id==3}  ">
                                                                                                {{schedule.players_count}}
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="row text-left">
                                                                                        <small>
                                                                                                <div v-if="schedule.players.length > 0">
                                                                                                    <span v-for="player in schedule.players" :key="player.id">
                                                                                                    {{player.name != null ? player.name : player.user.name+' '+player.user.surname }}/
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div v-else>
                                                                                                    <span>-</span>
                                                                                                </div>
                                                                                                
                                                                                            
                                                                                        </small> 
                                                                                        <!-- <div class="col rounded bg-light m-1" >
                                                                                            
                                                                                        </div> -->
                                                                                        
                                                                                    </div>
                                                                                </router-link>
                                                                               
                                                                            </div>
                                                                            <!-- Reservas -->
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <!-- CADA LINHA -->
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>

                                        </div>
                                        <hr>
                                        <h5 class="card-title mb-0">Visão Diária de Reservas</h5>
                                        <div class="m-4">
                                            <DatePicker v-model="selectedDate" view="weekly" expanded />
                                        </div>
                                        <div class="row">
                                                        <div class="col-12 col-lg-6" v-for="court in courtData" :key="court.id">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5 class="card-title">{{ court[0].court.name ?? 'Quadra' }} (<small>{{ moment(selectedDate).format('DD-MM-YYYY') }}</small>)</h5>
                                                                    
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="chart">
                                                                        <div class="row">
                                                                            <div class="col-4 col-lg-4 mb-2" v-for="schedule in court" :key="schedule.id">
                                                                                <router-link
                                                                                    :to="'/owner/schedules/' + schedule.id">
                                                                                <span class="badge bg-success" v-if="schedule.status_id==1">{{schedule.start_time}} - {{schedule.end_time}}</span>
                                                                                <span class="badge bg-warning" v-if="schedule.status_id==2">{{schedule.start_time}} - {{schedule.end_time}}</span>
                                                                                <span class="badge bg-danger" v-if="schedule.status_id==3">{{schedule.start_time}} - {{schedule.end_time}}</span>
                                                                            </router-link>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                       
                                                    </div>

                                        <!-- <div class="row">
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col mt-0">
                                                                <h5 class="card-title">Tipos de Equipamentos</h5>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="stat text-primary">
                                                                    <vue-feather type="list"></vue-feather>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h1 class="mt-1 mb-3">{{typeequipments}}</h1>
                                                        <div class="mb-0">
                                                             <router-link to="/admin/type_equipments"><vue-feather type="eye"></vue-feather></router-link>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col mt-0">
                                                                <h5 class="card-title">Tipos de Avarias</h5>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="stat text-primary">
                                                                    <vue-feather type="alert-triangle"></vue-feather>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h1 class="mt-1 mb-3">{{malfunctions}}</h1>
                                                        <div class="mb-0">
                                                             <router-link to="/admin/malfunctions"><vue-feather type="eye"></vue-feather></router-link>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col mt-0">
                                                                <h5 class="card-title">Fornecedores</h5>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="stat text-primary">
                                                                    <vue-feather type="truck"></vue-feather>
                                                           
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h1 class="mt-1 mb-3">{{suppliers}}</h1>
                                                        <div class="mb-0">
                                                             <router-link to="/admin/suppliers"><vue-feather type="eye"></vue-feather></router-link>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col mt-0">
                                                                <h5 class="card-title">Tarefas</h5>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="stat text-primary">
                                                                    <vue-feather type="tablet"></vue-feather>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h1 class="mt-1 mb-3">{{tasks}}</h1>
                                                        <div class="mb-0">
                                                             <router-link to="/admin/tasks"><vue-feather type="eye"></vue-feather></router-link>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col mt-0">
                                                                <h5 class="card-title">Equipamentos/Ativos</h5>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="stat text-primary">
                                                                    <vue-feather type="package"></vue-feather>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h1 class="mt-1 mb-3">{{equipments}}</h1>
                                                        <div class="mb-0">
                                                             <router-link to="/admin/equipments"><vue-feather type="eye"></vue-feather></router-link>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col mt-0">
                                                                <h5 class="card-title">MCSCR</h5>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="stat text-primary">
                                                                    <vue-feather type="database"></vue-feather>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h1 class="mt-1 mb-3">{{mcscr}}</h1>
                                                        <div class="mb-0">
                                                             <router-link to="/admin/mcscr"><vue-feather type="eye"></vue-feather></router-link>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                           
                                           
                                        </div> -->

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