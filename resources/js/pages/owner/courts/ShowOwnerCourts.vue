<script setup>
import axios from "axios";
import {
    ref,
    onMounted,
    reactive,
    defineEmits,
    defineComponent,
    watch,
} from "vue";
import moment from "moment";
import { useToastr } from "../../../toastr";
import { debounce } from "lodash";
import { Form, Field } from "vee-validate";
import { useRouter } from "vue-router";
import * as yup from "yup";
import VueFeather from "vue-feather";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import VCalendar from "v-calendar";
import { Calendar, DatePicker } from "v-calendar";

let retrievedData = ref([]);
let scheduleData = ref([]);
let loadingSubmit = ref([true]);
let loadingDiv = ref([true]);
let loadingBody = ref([false]);
let loadingButtonDelete = ref([false]);
const router = useRouter();
let self = this;
let loadingButtonSubmit = ref(false)
let searchQuery = ref(null);
let equipments = ref([]);
const loading = ref(false);
let prices = ref([]);
let currentvalue = ref([]);
let currentvalue2 = ref([]);
let currentvalue3 = ref([]);
const toastr = useToastr();
const selectedDate = ref(moment().format('YYYY-MM-DD'));
let dateToCopy = ref(null);
let date = ref();
let dataIdBeingDeleted = ref(null);

const schema = yup.object({
    date: yup.string().required(),
});

const schema2 = yup.object({
    date: yup.string().required(),
    start_date: yup.date().required(),
    // end_date: yup.string().required(),
    end_date:yup.date().required().min(yup.ref('start_date'),
    "end date can't be before start date")
   
});

const schema3 = yup.object({
    date: yup.date().required(),
    start_time: yup.string().required(),
    end_time: yup.string().required(),
    step: yup.string().required(),
    price_id: yup.string().required(),
    
    // end_date: yup.string().required(),
    // end_date:yup.date().required().min(yup.ref('start_date'),
    // "end date can't be before start date")
   
});

const getData = (page = 1) => {
    axios
        .get(`/owner-courts/+${router.currentRoute.value.params.id}?page=${page}`, {
            params: {
                query: searchQuery.value,
            },
        })
        .then((response) => {
            loadingDiv.value = false;
            retrievedData.value = response.data.court;
            scheduleData.value = response.data.schedule;
            prices.value = response.data.prices;
        })
        .catch(() => {
            loadingDiv.value = false;
        });
};

watch(
    searchQuery,
    debounce(() => {
        getData();
    }, 300)
);

watch(selectedDate, () => {
    loadingBody.value = true;
    var newDate = moment(selectedDate.value).format("Y-MM-D");
    // alert(newDate)

    axios
        .get(
            `/updatecourtschedule/${newDate}/${router.currentRoute.value.params.id}`
        )
        .then((response) => {
            retrievedData.value = response.data.court;
            scheduleData.value = response.data.schedule;
            prices.value = response.data.prices;
            loadingBody.value = false;
        
        })
        .catch(() => {
            loadingBody.value = false;
        });
    loadingBody.value = false;
});

const createRecordFunction = (values, actions) => {
    currentvalue.value = { values };

    loading.value = true;

    const arr = Array.from(values);

    axios
        .post("/owner-schedules", values)
        .then((response) => {
            // categories.value.unshift(response.data);
            // $('#createCategory').modal('hide');
            scheduleData.value = response.data;
            actions.resetForm();
            // router.push({ path: '/owner/courts' });
            toastr.success("Horario criado com sucesso");
        })
        .catch((error) => {
            loading.value = false;
            toastr.error("Erro ao adicionar. " + error.response.data.message);
            if (error.response.data.errors) {
                actions.setErrors(error.response.data.errors);
            }
        })
        .finally(() => {
            loading.value = false;
        });
};

const confirmCopy = (data) => {
    dateToCopy = selectedDate == null ? new Date() : selectedDate;

    $("#copyModal").modal("show");
    // axios.post('/categories',values).then((response)=>{

    //   categories.value.unshift(response.data);
    //   $('#createCategory').modal('hide');
    //   resetForm();
    // })
};

const copyRecordFunction = (values, actions) =>{
    currentvalue2.value = { values };
    loadingButtonSubmit.value= true;

axios.post(`/owner-schedule-copy`,values)
.then((response)=>{
//  retriviedData.value.data = retriviedData.value.data.filter(data=>data.id !== dataIdBeingDeleted); 
 $('#copyModal').modal('hide');
 retrievedData.value = response.data.court;
            scheduleData.value = response.data.schedule;
            prices.value = response.data.prices;
            // router.push({ path: '/owner/courts' });
 toastr.success('Registro copiado com sucesso');

}).catch((response)=>{
    console.log(response);
 toastr.error('Erro ao copiar.'+response.response.data.message);
 loadingButtonSubmit.value= false;
 $('#copyModal').modal('hide');
}).finally(()=>{
 loadingButtonSubmit.value= false;
});
}

const generateRecordFunction = (values, actions) =>{
    currentvalue3.value = { values };
    loadingButtonSubmit.value= true;

axios.post(`/owner-schedule-generate`,values)
.then((response)=>{
//  retriviedData.value.data = retriviedData.value.data.filter(data=>data.id !== dataIdBeingDeleted); 

retrievedData.value = response.data.court;
            scheduleData.value = response.data.schedule;
            prices.value = response.data.prices;
 toastr.success('Registro gerado com sucesso');

}).catch((response)=>{
    console.log(response);
 toastr.error('Erro ao gerar.'+response.response.data.message);
 loadingButtonSubmit.value= false;
 $('#copyModal').modal('hide');
}).finally(()=>{
 loadingButtonSubmit.value= false;
});
}

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

axios.delete(`/owner-schedules/${dataIdBeingDeleted}`)
.then(()=>{
 scheduleData.value.data = scheduleData.value.data.filter(data=>data.id !== dataIdBeingDeleted); 
 $('#deleteModal').modal('hide');

 toastr.success('Registro apagado com sucesso');

}).catch((response)=>{
    console.log(response);
 toastr.error('Erro ao apagar.'+response.response.data.message);
 loadingButtonDelete.value= false;
 $('#deleteModal').modal('hide');
}).finally(()=>{
 loadingButtonDelete.value= false;
});
}

onMounted(() => {
    getData();
});
</script>

<template>
    <div v-if="!loadingDiv">
        <h1 class="h3 mb-3">Quadra</h1>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Quadra: {{ retrievedData.name }}</h5>

                        <router-link to="/owner/courts" class="btn btn-pill btn-primary mt-3"><vue-feather
                                type="arrow-left"></vue-feather>Voltar</router-link>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-xxl-12 d-flex">
                                <div class="w-100">
                                    <p>Nome da Quadra: {{ retrievedData.name }}</p>
                                    <p>Limite: {{ retrievedData.limit }}</p>
                                    <p>Descrição: {{ retrievedData.description }}</p>

                                    <hr />
                                    <a class="btn btn-pill btn-primary mt-3 mr-3" data-toggle="collapse"
                                        href="#collapseExample" role="button" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        <vue-feather type="plus"></vue-feather>Adicionar Horário
                                    </a>
                                    <a class="btn btn-pill btn-primary mt-3 mr-3" data-toggle="collapse"
                                        href="#collapseExample2" role="button" aria-expanded="false"
                                        aria-controls="collapseExample2">
                                        <vue-feather type="plus"></vue-feather>Gerar Horário
                                    </a>
                                    <div class="collapse mt-3" id="collapseExample2">
                                        <div class="card-body">
                                            <h4>Gerar Horário</h4>
                                            <Form @submit="generateRecordFunction" :validation-schema="schema3"
                                                v-slot="{ errors }">
                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label class="form-label" for="name">Data</label>
                                                        <Field type="date" class="form-control"
                                                            :class="{ 'is-invalid': errors.date }" name="date" id="date"
                                                            placeholder="Data" />
                                                        <Field type="hidden" class="form-control"
                                                            :class="{ 'is-invalid': errors.court_id }" name="court_id"
                                                            id="date" v-model="retrievedData.id" placeholder="Data" />
                                                        <span class="invalid-feedback">{{
                                                            errors.date
                                                        }}</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label class="form-label" for="start_time">Horas de Inicio</label>
                                                        <Field type="time" step="3600" class="form-control"
                                                            :class="{ 'is-invalid': errors.start_time }" name="start_time" id="start_time"
                                                            placeholder="Data" />
                                                        <span class="invalid-feedback">{{
                                                            errors.start_time
                                                        }}</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label class="form-label" for="end_time">Horas de Fim</label>
                                                        <Field type="time" step="3600" class="form-control" 
                                                            :class="{ 'is-invalid': errors.end_time }" name="end_time" id="end_time"
                                                            placeholder="Data" />
                                                        <span class="invalid-feedback">{{
                                                            errors.end_time
                                                        }}</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label class="form-label" for="step">Step</label>
                                                        <Field as="select" class="form-control"
                                                            :class="{ 'is-invalid': errors.step }" name="step" id="step"
                                                            placeholder="Step">
                                                            <option value="30" selected>30 Minutos</option>
                                                            <option value="60">60 Minutos</option>
                                                        </Field>
                                                        <span class="invalid-feedback">{{
                                                            errors.step
                                                        }}</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label class="form-label" for="price_id">Preço</label>
                                                        <Field as="select" class="form-control"
                                                            :class="{ 'is-invalid': errors.price_id }" name="price_id"
                                                            id="price_id" aria-describedby="price_id">
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
                                                <button type="submit" class="btn btn-primary" :disabled="loading">
                                                    <div v-if="loading" class="spinner-border spinner-border-sm"
                                                        role="status"></div>
                                                    <span v-else>Submeter</span>
                                                </button>
                                            </Form>
                                        </div>
                                    </div>
                                    <div class="collapse mt-3" id="collapseExample">
                                        <div class="card-body">
                                            <h4>Adicionar Horário</h4>
                                            <Form @submit="createRecordFunction" :validation-schema="schema"
                                                v-slot="{ errors }">
                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label class="form-label" for="name">Data</label>
                                                        <Field type="date" class="form-control"
                                                            :class="{ 'is-invalid': errors.date }" name="date" id="date"
                                                            placeholder="Data" />
                                                        <Field type="hidden" class="form-control"
                                                            :class="{ 'is-invalid': errors.court_id }" name="court_id"
                                                            id="date" v-model="retrievedData.id" placeholder="Data" />
                                                        <span class="invalid-feedback">{{
                                                            errors.date
                                                        }}</span>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label class="form-label" for="start_time">Horas de Inicio</label>
                                                        <Field type="time" class="form-control"
                                                            :class="{ 'is-invalid': errors.date }" name="start_time"
                                                            id="start_time" placeholder="Horas de inicio" />
                                                        <span class="invalid-feedback">{{
                                                            errors.start_time
                                                        }}</span>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label class="form-label" for="end_time">Horas de Fim</label>
                                                        <Field type="time" class="form-control"
                                                            :class="{ 'is-invalid': errors.end_time }" name="end_time"
                                                            id="end_time" placeholder="Horas de Fim" />
                                                        <span class="invalid-feedback">{{
                                                            errors.end_time
                                                        }}</span>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-4">
                                                        <label class="form-label" for="price_id">Preço</label>
                                                        <Field as="select" class="form-control"
                                                            :class="{ 'is-invalid': errors.price_id }" name="price_id"
                                                            id="price_id" aria-describedby="price_id">
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

                                                <button type="submit" class="btn btn-primary" :disabled="loading">
                                                    <div v-if="loading" class="spinner-border spinner-border-sm"
                                                        role="status"></div>
                                                    <span v-else>Submeter</span>
                                                </button>
                                            </Form>
                                        </div>
                                    </div>
                                    <div class="m-4">
                                        <DatePicker v-model="selectedDate" view="weekly" expanded />
                                    </div>

                                    <div v-if="(loadingBody = false)">
                                        <div class="d-flex justify-content-center">
                                            <div class="spinner-border" role="status">
                                                <span class="sr-only"></span>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="d-flex justify-content-center">
                                            Carregando Dados...
                                        </div>
                                    </div>
                                    <div v-if="(loadingBody = true)">
                                        <h4>
                                            Data:
                                            {{
                                                selectedDate == null
                                                ? moment(Date()).format("DD-MM-YYYY")
                                                : moment(selectedDate).format("DD-MM-YYYY")
                                            }}
                                        </h4>
                                        <a class="btn btn-pill btn-primary mt-3 mr-3" href="#"
                                            @click.prevent="confirmCopy(selectedDate)">
                                            <vue-feather type="copy"></vue-feather> Copiar Horário de
                                            {{
                                                selectedDate == null
                                                ? moment(Date()).format("DD-MM-YYYY")
                                                : moment(selectedDate).format("DD-MM-YYYY")
                                            }}
                                        </a>
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
                                                    <tr v-for="(actualData, index) in scheduleData.data"
                                                        :key="actualData.id">
                                                        <td>#{{ index + 1 }}</td>
                                                        <td>{{ actualData.court.name }}</td>
                                                        <td>{{ actualData.date }}</td>
                                                        <td>{{ actualData.start_time }}</td>
                                                        <td>{{ actualData.end_time }}</td>
                                                        <td>
                                                            {{
                                                                actualData.price.name +
                                                                "( " +
                                                                actualData.price.price +
                                                                actualData.price.coin.symbol +
                                                                " )"
                                                            }}
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-success"
                                                                v-if="actualData.status_id == 1">{{
                                                                    actualData.status.name +
                                                                    "(" +
                                                                    actualData.players_count +
                                                                    ")"
                                                                }}</span>
                                                            <span class="badge bg-warning"
                                                                v-if="actualData.status_id == 2">{{
                                                                    actualData.status.name +
                                                                    "(" +
                                                                    actualData.players_count +
                                                                    ")"
                                                                }}</span>
                                                            <span class="badge bg-danger"
                                                                v-if="actualData.status_id == 3">{{
                                                                    actualData.status.name +
                                                                    "(" +
                                                                    actualData.players_count +
                                                                    ")"
                                                                }}</span>
                                                        </td>

                                                        <td>
                                                            <router-link :to="'/owner/schedules/'+actualData.id+'/edit'"><vue-feather type="edit-2"></vue-feather></router-link>
                                                            <router-link
                                                                :to="'/owner/schedules/' + actualData.id"><vue-feather
                                                                    type="eye"></vue-feather></router-link>
                                                            <a href="#" @click.prevent="confirmDeletion(actualData)"><vue-feather type="trash"></vue-feather></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else>
                                                    <tr>
                                                        <td colspan="9" align="center">
                                                            Nenhum resultado encontrado
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <Bootstrap4Pagination :data="scheduleData" @pagination-change-page="getData" />
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
                <br />
                <div class="d-flex justify-content-center">Carregando Dados...</div>
            </div>
        </div>
    </div>

    <div class="modal" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="copyModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Deseja efetuar a copia do Horário do dia
                        {{ moment(selectedDate).format("DD-MM-YYYY") }} ?
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form @submit="copyRecordFunction" :validation-schema="schema2" v-slot="{ errors }">
                <div class="modal-body">
                    Selecione as datas para efectuar a cópia.

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="start_date">Data Inicio</label>
                            <Field type="date" class="form-control" :class="{ 'is-invalid': errors.start_date }" name="start_date"
                                id="start_date" placeholder="Data Inicio" />
                            <Field type="hidden" class="form-control" :class="{ 'is-invalid': errors.court_id }" name="date"
                                id="date" v-model="selectedDate" placeholder="Data" />
                                <Field type="hidden" class="form-control" :class="{ 'is-invalid': errors.court_id }" name="court_id"
                                id="court_id" v-model="retrievedData.id" placeholder="" />
                            <span class="invalid-feedback">{{ errors.start_date }}</span>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="end_date">Data Fim</label>
                            <Field type="date" class="form-control" :class="{ 'is-invalid': errors.end_date }"
                                name="end_date" id="end_date" placeholder="Data Fim" />

                            <span class="invalid-feedback">{{ errors.end_date }}</span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Fechar
                    </button>
                    <button type="submit" class="btn btn-danger"
                        :disabled="loadingButtonSubmit">
                        <div v-if="loadingButtonSubmit" class="spinner-border spinner-border-sm" role="status"></div>
                        <span v-else>Copiar Horário</span>
                    </button>
                </div>
                </Form>
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
                <button @click.prevent="deleteData" type="button" class="btn btn-danger">
                    <!-- <div v-if="loadingButtonDelete" class="spinner-border spinner-border-sm" role="status"></div> -->
                    <span>Apagar registro</span>
                </button>
         
          
        </div>
      </div>
    </div>
  </div>
</template>