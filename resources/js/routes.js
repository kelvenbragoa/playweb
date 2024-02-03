//IMPORT COMPONENT FOR ADMIN ROUTES
import Login from './pages/auth/Login.vue';
import Register from './pages/auth/Register.vue';
import Home from './pages/home/Home.vue';

export default [
    //auth
    {
        path: '/login',
        name: 'users.login',
        component: Login,
    },
    {
        path: '/register',
        name: 'users.register',
        component: Register,
    },

    //home
    {
        path: '/home',
        name: 'home',
        component: Home,
    },
    {
        path: '/',
        name: 'mainhome',
        component: Home,
    },
]