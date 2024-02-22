//IMPORT COMPONENT FOR ADMIN ROUTES
import Login from './pages/auth/Login.vue';
import Register from './pages/auth/Register.vue';
import Home from './pages/home/Home.vue';
import Clubs from './pages/home/Clubs.vue';
import Schedule from './pages/home/Schedule.vue';
import DashboardAdmin from './components/DashboardAdmin.vue';
import DashboardOwner from './components/DashboardOwner.vue';

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

//OWNER IMPORT----------------------------------------------------------------

import IndexOwnerCourts from './pages/owner/courts/IndexOwnerCourts.vue';
import CreateOwnerCourts from './pages/owner/courts/CreateOwnerCourts.vue';
import ShowOwnerCourts from './pages/owner/courts/ShowOwnerCourts.vue';
import EditOwnerCourts from './pages/owner/courts/EditOwnerCourts.vue';

import IndexOwnerClub from './pages/owner/club/IndexOwnerClub.vue';
import CreateOwnerClub from './pages/owner/club/CreateOwnerClub.vue';
import ShowOwnerClub from './pages/owner/club/ShowOwnerClub.vue';
import EditOwnerClub from './pages/owner/club/EditOwnerClub.vue';

import IndexOwnerPrices from './pages/owner/prices/IndexOwnerPrices.vue';
import CreateOwnerPrices from './pages/owner/prices/CreateOwnerPrices.vue';
import ShowOwnerPrices from './pages/owner/prices/ShowOwnerPrices.vue';
import EditOwnerPrices from './pages/owner/prices/EditOwnerPrices.vue';

import IndexOwnerSchedules from './pages/owner/schedules/IndexOwnerSchedules.vue';
import CreateOwnerSchedules from './pages/owner/schedules/CreateOwnerSchedules.vue';
import ShowOwnerSchedules from './pages/owner/schedules/ShowOwnerSchedules.vue';
import EditOwnerSchedules from './pages/owner/schedules/EditOwnerSchedules.vue';

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
    {
        path: '/clubs/:id',
        name: 'home.clubs.show',
        component: Clubs,
    },
    {
        path: '/schedule/courts/:id',
        name: 'home.courts.schedule',
        component: Schedule,
    },




    //admins
    {
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        component: DashboardAdmin,
    },

    {
        path: '/owner/dashboard',
        name: 'owner.dashboard',
        component: DashboardOwner,
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




    //OWNER ROUTER ------------------------------------------------------------------------------------------------

    //courts
    {
        path: '/owner/courts',
        name: 'owner.courts.index',
        component: IndexOwnerCourts,
    },
    {
        path: '/owner/courts/create',
        name: 'owner.courts.create',
        component: CreateOwnerCourts,
    },
    {
        path: '/owner/courts/:id',
        name: 'owner.courts.show',
        component: ShowOwnerCourts,
    },
    {
        path: '/owner/courts/:id/edit',
        name: 'owner.courts.edit',
        component: EditOwnerCourts,
    },

    //courts
    {
        path: '/owner/club',
        name: 'owner.club.index',
        component: IndexOwnerClub,
    },
    {
        path: '/owner/club/create',
        name: 'owner.club.create',
        component: CreateOwnerClub,
    },
    {
        path: '/owner/club/:id',
        name: 'owner.club.show',
        component: ShowOwnerClub,
    },
    {
        path: '/owner/club/:id/edit',
        name: 'owner.club.edit',
        component: EditOwnerClub,
    },

     //prices
     {
        path: '/owner/prices',
        name: 'owner.prices.index',
        component: IndexOwnerPrices,
    },
    {
        path: '/owner/prices/create',
        name: 'owner.prices.create',
        component: CreateOwnerPrices,
    },
    {
        path: '/owner/prices/:id',
        name: 'owner.prices.show',
        component: ShowOwnerPrices,
    },
    {
        path: '/owner/prices/:id/edit',
        name: 'owner.prices.edit',
        component: EditOwnerPrices,
    },

     //schedules
    //  {
    //     path: '/owner/schedules',
    //     name: 'owner.schedules.index',
    //     component: IndexOwnerSchedules,
    // },
    // {
    //     path: '/owner/schedules/create',
    //     name: 'owner.schedules.create',
    //     component: CreateOwnerSchedules,
    // },
    {
        path: '/owner/schedules/:id',
        name: 'owner.schedules.show',
        component: ShowOwnerSchedules,
    },
    {
        path: '/owner/schedules/:id/edit',
        name: 'owner.schedules.edit',
        component: EditOwnerSchedules,
    },
]