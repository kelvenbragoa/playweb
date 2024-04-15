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

const courtData2 = ref([])
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
        courtData2.value = response.data.courtData2
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

                                      
                                       
                                    
                                        <h5 class="card-title mb-0">Visão Diária de Reservas</h5>
                                        <div class="m-4">
                                            <DatePicker v-model="selectedDate" view="weekly" expanded />
                                        </div>
                                        <div class="row">
                                            <!-- <div class="table-responsive">
                                            <table class="table table-bordered table-hover my-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th v-for="court in courtData" :key="court.id">{{ court[0].court.name ?? 'Quadra' }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(sc,index) in courtData2" :key="sc.id">
                                                        <td>{{ index }}</td>
                                                        <td>{{ sc }}</td>
                                                        <td>{{ sc }}</td>
                                                    </tr>
                                                    <div v-for="court in courtData" :key="court.id">
                                                        <tr v-for="schedule in court" :key="schedule.id" >
                                                            <td>{{schedule.court_id}}</td>
                                                            <td>{{schedule.court_id}}</td>
                                                            
                                                        </tr>
                                                    </div> 
                                                    
                                                </tbody>
                                            </table>
                                        </div> -->

                                        <!-- <div class="table-responsive">
                                            <table class="table table-bordered table-hover my-0">
                                                <thead>
                                                    <tr>
                                                        <th v-for="court in courtData" :key="court.id" >{{ court[0].court.name ?? 'Quadra' }}</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>aa</td>
                                                        <td>aa</td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> -->

                                        
                                        <div style="width: fit-content; overflow-x: auto; white-space: nowrap; display: flex;justify-content: space-around;">
                                            <div v-for="court in courtData" :key="court.id">
                                                <table class=" table-bordered">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ court[0].court.name ?? 'Quadra' }}</th>
                                                        
                                                    </tr>
                                                    <tr  v-for="schedule in court" :key="schedule.id">
                                                        <td>{{schedule.start_time}}</td>
                                                        <td class="bg-success" v-if="schedule.status_id==1">
                                                            <router-link :to="'/owner/schedules/' + schedule.id">
                                                                {{ schedule.players_count }} Jogadores
                                                            </router-link>
                                                        </td>
                                                        <td class="bg-warning" v-if="schedule.status_id==2">
                                                            <router-link :to="'/owner/schedules/' + schedule.id">
                                                                <div>
                                                                    <span v-for="player in schedule.players">
                                                                        {{player.name != null ? player.name : player.user.name+' '+player.user.surname }} <br>
                                                                    </span>
                                                                </div>
                                                                
                                                            </router-link>
                                                        </td>
                                                        <td class="bg-danger" v-if="schedule.status_id==3">
                                                            <router-link :to="'/owner/schedules/' + schedule.id">
                                                                <div>
                                                                    <span v-for="player in schedule.players">{{ player.name }} <br></span>
                                                                </div>
                                                            </router-link>
                                                        </td>
                                                    
                                                    </tr>
                                                </table>
                                            </div>
                                        
                                        </div>
                                        

                                        <!-- <div style="width: 300px; overflow-x: auto; white-space: nowrap;" >
                                            
                                        <table class="table table-bordered table-hover" v-for="court in courtData" :key="court.id">
                                                <thead>
                                                    <tr>
                                                        <th class="width-80">#</th>
                                                        <th>{{ court[0].court.name ?? 'Quadra' }}</th> 
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <tr v-for="schedule in court" :key="schedule.id">
                                                            <td>{{schedule.start_time}} - {{schedule.end_time}}</td>
                                                            <td>
                                                                <router-link :to="'/owner/schedules/' + schedule.id">
                                                                a
                                                                </router-link>
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div> -->

                                            
                                                        <!-- <div class="col-12 col-lg-6" v-for="court in courtData" :key="court.id">
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
                                                        </div> -->

                                                       
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
<style>
table {
    min-width: 1px;
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
  
}

tr:nth-child(even) {background-color: #f2f2f2;}
</style>