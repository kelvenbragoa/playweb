import './bootstrap';
import 'toastr/build/toastr.min.css';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import Routes from './routes';
import Login from './pages/auth/Login.vue';





const app = createApp({});
const router = createRouter({
    routes:Routes,
    history:createWebHistory(),
});




app.component('Login',Login);
app.use(router);
app.mount('#app');