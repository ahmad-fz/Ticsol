import Vue from 'vue';
import VueRouter from 'vue-router';
import { store } from './store/store.js';

Vue.use(VueRouter);

export const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'auth',
            redirect: { name: 'login' },
            meta: { requireAuth: false },
            component: require('./components/pages/auth/Auth.vue'),
            children: [
                {
                    path: 'login',
                    name: 'login',
                    meta: { requireAuth: false },
                    component: require('./components/pages/auth/Login.vue')
                },
                {
                    path: 'logout',
                    name: 'logout',
                    meta: { requireAuth: false },
                    component: require('./components/pages/auth/Logout.vue')
                },
                {
                    path: 'register',
                    name: 'register',
                    meta: { requireAuth: false },
                    component: require('./components/pages/auth/Register.vue')
                },
                {
                    path: 'resetpassword',
                    name: 'resetpassword',
                    meta: { requireAuth: false },
                    component: require('./components/pages/auth/ResetPassword.vue')
                },
            ]
        },
        {
            path: '/dash',
            name: 'dash',
            meta: { requireAuth: true },
            redirect: { name: 'home' },
            component: require('./components/pages/dashboard/Dashboard.vue'),
            children: [
                {
                    path: '/home',
                    name: 'home',
                    meta: { requireAuth: true },
                    component: require('./components/pages/dashboard/Home.vue')
                },
                {
                    path: '/inbox',
                    name: 'inbox',
                    meta: { requireAuth: true },
                    redirect: { name: 'inboxList' },
                    component: require('./components/pages/dashboard/inbox/Inbox.vue'),
                    children: [
                        {
                            path: 'list',
                            name: 'inboxList',
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/inbox/InboxList.vue'),
                        }
                    ]
                },
                {
                    path: '/hr',
                    name: 'hr',
                    meta: { requireAuth: true },
                    component: require('./components/pages/dashboard/HRs/HRs.vue'),
                    children: [

                    ]
                },
                {
                    path: '/requests',
                    name: 'requests',
                    meta: { requireAuth: true },
                    component: require('./components/pages/dashboard/requests/Requests.vue'),
                    children: [

                    ]
                },
                {
                    path: '/schedules',
                    name: 'schedule',
                    meta: { requireAuth: true },
                    redirect: { name: 'scheduler' },
                    component: require('./components/pages/dashboard/schedules/Schedules.vue'),
                    children: [
                        {
                            path: '/scheduler',
                            name: 'scheduler',
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/schedules/Scheduler.vue'),
                        }
                    ]
                },
                {
                    path: '/timesheets',
                    name: 'timesheets',
                    meta: { requireAuth: true },
                    component: require('./components/pages/dashboard/timesheets/TimeSheets.vue'),
                    children: [

                    ]
                },
                {
                    path: '/jobs',
                    name: 'jobs',
                    meta: { requireAuth: true },
                    redirect: { name: 'jobList' },
                    component: require('./components/pages/dashboard/jobs/Jobs.vue'),
                    children: [
                        {
                            path: 'list',
                            name: 'jobList',
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/jobs/JobList.vue'),
                        },
                        {
                            path: 'create',
                            name: 'jobCreate',
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/jobs/JobCreate.vue'),
                        },                       
                        {
                            path: ':id/details',                            
                            name: 'jobDetails',
                            props: true,
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/jobs/JobDetails.vue'),
                        },
                        {
                            path: ':id/related-jobs',
                            name: 'jobChilds',
                            props: true,
                            meta: { requireAuth: true },
                        },
                        {
                            path: ':id/contacts',
                            name: 'jobContacts',
                            props: true,
                            meta: { requireAuth: true },
                        },
                        {
                            path: ':id/scheduled-items',
                            name: 'jobItems',
                            props: true,
                            meta: { requireAuth: true },
                        },
                        {
                            path: ':id/reports',
                            name: 'jobReports',
                            props: true,
                            meta: { requireAuth: true },
                        },
                        {
                            path: ':id/requests',
                            name: 'jobRequests',
                            props: true,
                            meta: { requireAuth: true },
                        },
                    ]
                },
                {
                    path: '/activity',
                    name: 'activity',
                    meta: { requireAuth: true },
                    redirect: { name: 'activityCreate' },
                    component: require('./components/pages/dashboard/activities/Activity.vue'),
                    children: [  
                        {
                            path: 'list',
                            name: 'activityList',
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/activities/ActivityList.vue'),
                        },                            
                        {
                            path: 'create',
                            name: 'activityCreate',
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/activities/ActivityCreate.vue'),
                        },
                        {
                            path: ':id/details',
                            name: 'activityDetails',
                            props: true,
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/activities/ActivityDetails.vue'),
                        }                            
                    ]
                },
                {
                    path: '/contact',
                    name: 'contact',
                    meta: { requireAuth: true },
                    redirect: { name: 'contactCreate' },
                    component: require('./components/pages/dashboard/contacts/Contacts.vue'),
                    children: [                        
                        {
                            path: 'create',
                            name: 'contactCreate',
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/contacts/ContactCreate.vue'),
                        }                        
                    ]
                },
                {
                    path: '/profile',
                    name: 'profile',
                    meta: { requireAuth: true },
                    redirect: { name: 'profileCreate' },
                    component: require('./components/pages/dashboard/profiles/Profiles.vue'),
                    children: [                        
                        {
                            path: 'list',
                            name: 'profileList',
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/profiles/ProfileList.vue'),
                        },
                        {
                            path: 'create',
                            name: 'profileCreate',
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/profiles/ProfileCreate.vue'),
                        },
                        {
                            path: ':id/details',
                            name: 'profileDetails',
                            props: true,
                            meta: { requireAuth: true },
                            component: require('./components/pages/dashboard/profiles/ProfileDetails.vue'),
                        }                        
                    ]
                },


            ]
        },

    ]
});

// router.beforeEach((to, from, next) => {
//     var state = store.state.auth;
//     if (to.meta.requireAuth === true && state.isAuth === false) {
//         next('/');
//     } else {
//         next();
//     }
//     next();
// });