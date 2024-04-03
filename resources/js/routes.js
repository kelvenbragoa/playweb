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

import IndexOwnerRecharges from './pages/owner/recharges/IndexOwnerRecharges.vue';
import CreateOwnerRecharges from './pages/owner/recharges/CreateOwnerRecharges.vue';
import ShowOwnerRecharges from './pages/owner/recharges/ShowOwnerRecharges.vue';
import EditOwnerRecharges from './pages/owner/recharges/EditOwnerRecharges.vue';

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
        meta: {
            requiresAuth: true
        },
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
        meta: {
            requiresAuth: true
        },
        component: Clubs,
    },
    {
        path: '/schedule/courts/:id',
        name: 'home.courts.schedule',
        meta: {
            requiresAuth: true
        },
        component: Schedule,
    },




    //admins
    {
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        meta: {
            requiresAuth: true
        },
        component: DashboardAdmin,
    },

    {
        path: '/owner/dashboard',
        name: 'owner.dashboard',
        meta: {
            requiresAuth: true
        },
        component: DashboardOwner,
    },

    //users
    {
        path: '/admin/users',
        name: 'admin.users.index',
        meta: {
            requiresAuth: true
        },
        component: IndexUsers,
    },
    {
        path: '/admin/users/create',
        name: 'admin.users.create',
        meta: {
            requiresAuth: true
        },
        component: CreateUsers,
    },
    {
        path: '/admin/users/:id',
        name: 'admin.users.show',
        meta: {
            requiresAuth: true
        },
        component: ShowUsers,
    },
    {
        path: '/admin/users/:id/edit',
        name: 'admin.users.edit',
        meta: {
            requiresAuth: true
        },
        component: EditUsers,
    },

    //courts
    {
        path: '/admin/courts',
        name: 'admin.courts.index',
        meta: {
            requiresAuth: true
        },
        component: IndexCourts,
    },
    {
        path: '/admin/courts/create',
        name: 'admin.courts.create',
        meta: {
            requiresAuth: true
        },
        component: CreateCourts,
    },
    {
        path: '/admin/courts/:id',
        name: 'admin.courts.show',
        meta: {
            requiresAuth: true
        },
        component: ShowCourts,
    },
    {
        path: '/admin/courts/:id/edit',
        name: 'admin.courts.edit',
        meta: {
            requiresAuth: true
        },
        component: EditCourts,
    },

     //schedules
     {
        path: '/admin/schedules',
        name: 'admin.schedules.index',
        meta: {
            requiresAuth: true
        },
        component: IndexSchedules,
    },
    {
        path: '/admin/schedules/create',
        name: 'admin.schedules.create',
        meta: {
            requiresAuth: true
        },
        component: CreateSchedules,
    },
    {
        path: '/admin/schedules/:id',
        name: 'admin.schedules.show',
        meta: {
            requiresAuth: true
        },
        component: ShowSchedules,
    },
    {
        path: '/admin/schedules/:id/edit',
        name: 'admin.schedules.edit',
        meta: {
            requiresAuth: true
        },
        component: EditSchedules,
    },




    //OWNER ROUTER ------------------------------------------------------------------------------------------------

    //courts
    {
        path: '/owner/courts',
        name: 'owner.courts.index',
        meta: {
            requiresAuth: true
        },
        component: IndexOwnerCourts,
    },
    {
        path: '/owner/courts/create',
        name: 'owner.courts.create',
        meta: {
            requiresAuth: true
        },
        component: CreateOwnerCourts,
    },
    {
        path: '/owner/courts/:id',
        name: 'owner.courts.show',
        meta: {
            requiresAuth: true
        },
        component: ShowOwnerCourts,
    },
    {
        path: '/owner/courts/:id/edit',
        name: 'owner.courts.edit',
        meta: {
            requiresAuth: true
        },
        component: EditOwnerCourts,
    },

    //courts
    {
        path: '/owner/club',
        name: 'owner.club.index',
        meta: {
            requiresAuth: true
        },
        component: IndexOwnerClub,
    },
    {
        path: '/owner/club/create',
        name: 'owner.club.create',
        meta: {
            requiresAuth: true
        },
        component: CreateOwnerClub,
    },
    {
        path: '/owner/club/:id',
        name: 'owner.club.show',
        meta: {
            requiresAuth: true
        },
        component: ShowOwnerClub,
    },
    {
        path: '/owner/club/:id/edit',
        name: 'owner.club.edit',
        meta: {
            requiresAuth: true
        },
        component: EditOwnerClub,
    },

     //prices
     {
        path: '/owner/prices',
        name: 'owner.prices.index',
        meta: {
            requiresAuth: true
        },
        component: IndexOwnerPrices,
    },
    {
        path: '/owner/prices/create',
        name: 'owner.prices.create',
        meta: {
            requiresAuth: true
        },
        component: CreateOwnerPrices,
    },
    {
        path: '/owner/prices/:id',
        name: 'owner.prices.show',
        meta: {
            requiresAuth: true
        },
        component: ShowOwnerPrices,
    },
    {
        path: '/owner/prices/:id/edit',
        name: 'owner.prices.edit',
        meta: {
            requiresAuth: true
        },
        component: EditOwnerPrices,
    },

     //recharge
     {
        path: '/owner/recharges',
        name: 'owner.recharges.index',
        meta: {
            requiresAuth: true
        },
        component: IndexOwnerRecharges,
    },
    {
        path: '/owner/recharges/create',
        name: 'owner.recharges.create',
        meta: {
            requiresAuth: true
        },
        component: CreateOwnerRecharges,
    },
    {
        path: '/owner/recharges/:id',
        name: 'owner.recharges.show',
        meta: {
            requiresAuth: true
        },
        component: ShowOwnerRecharges,
    },
    {
        path: '/owner/recharges/:id/edit',
        name: 'owner.recharges.edit',
        meta: {
            requiresAuth: true
        },
        component: EditOwnerRecharges,
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
        meta: {
            requiresAuth: true
        },
        component: ShowOwnerSchedules,
    },
    {
        path: '/owner/schedules/:id/edit',
        name: 'owner.schedules.edit',
        meta: {
            requiresAuth: true
        },
        component: EditOwnerSchedules,
    },
]