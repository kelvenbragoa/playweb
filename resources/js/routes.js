//IMPORT COMPONENT FOR ADMIN ROUTES
import Login from './pages/auth/Login.vue';
import Register from './pages/auth/Register.vue';
import Home from './pages/home/Home.vue';
import DashboardAdmin from './components/DashboardAdmin.vue';

import IndexUsers from './pages/admin/users/IndexUsers.vue';
import CreateUsers from './pages/admin/users/CreateUsers.vue';
import ShowUsers from './pages/admin/users/ShowUsers.vue';
import EditUsers from './pages/admin/users/EditUsers.vue';

import IndexCourts from './pages/admin/courts/IndexCourts.vue';
import CreateCourts from './pages/admin/courts/CreateCourts.vue';
import ShowCourts from './pages/admin/courts/ShowCourts.vue';
import EditCourts from './pages/admin/courts/EditCourts.vue';

import IndexSchedules from './pages/admin/schedules/IndexSchedules.vue';
import CreateSchedules from './pages/admin/schedules/CreateSchedules.vue';
import ShowSchedules from './pages/admin/schedules/ShowSchedules.vue';
import EditSchedules from './pages/admin/schedules/EditSchedules.vue';

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
    //admins
    {
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        component: DashboardAdmin,
    },

    //users
    {
        path: '/admin/users',
        name: 'admin.users.index',
        component: IndexUsers,
    },
    {
        path: '/admin/users/create',
        name: 'admin.users.create',
        component: CreateUsers,
    },
    {
        path: '/admin/users/:id',
        name: 'admin.users.show',
        component: ShowUsers,
    },
    {
        path: '/admin/users/:id/edit',
        name: 'admin.users.edit',
        component: EditUsers,
    },

    //courts
    {
        path: '/admin/courts',
        name: 'admin.courts.index',
        component: IndexCourts,
    },
    {
        path: '/admin/courts/create',
        name: 'admin.courts.create',
        component: CreateCourts,
    },
    {
        path: '/admin/courts/:id',
        name: 'admin.courts.show',
        component: ShowCourts,
    },
    {
        path: '/admin/courts/:id/edit',
        name: 'admin.courts.edit',
        component: EditCourts,
    },

     //schedules
     {
        path: '/admin/schedules',
        name: 'admin.schedules.index',
        component: IndexSchedules,
    },
    {
        path: '/admin/schedules/create',
        name: 'admin.schedules.create',
        component: CreateSchedules,
    },
    {
        path: '/admin/schedules/:id',
        name: 'admin.schedules.show',
        component: ShowSchedules,
    },
    {
        path: '/admin/schedules/:id/edit',
        name: 'admin.schedules.edit',
        component: EditSchedules,
    },
]