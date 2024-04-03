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

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        const token = localStorage.getItem('token');
        if (token) {
            // User is authenticated, proceed to the route
            next();
        } else {
            // User is not authenticated, redirect to login
            next('/login');
        }
    } else {
        // Non-protected route, allow access
        next();
    }

    // if (to.meta.hideForAuth) {
    //     const token = localStorage.getItem('token');
    //     if (token) {
    //         // User is authenticated, proceed to the route
    //         next('/dashboard');
    //     } else {
    //         // User is not authenticated, redirect to login
    //         next('/dashboard');
    //     }
    // } else {
    //     // Non-protected route, allow access
    //     next('/dashboard');
    // }
});




app.component('Login',Login);
app.use(router);
app.mount('#app');