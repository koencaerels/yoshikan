import {createRouter, createWebHashHistory} from 'vue-router'

import HomeView from '../views/HomeView.vue'

const router = createRouter({
    history: createWebHashHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/inschrijvingen',
            name: 'inschrijvingen',
            component: HomeView,
            children: [
                {
                    path: 'todo',
                    name: 'todo',
                    component: () => import('../views/subscription/SubscriptionStartView.vue')
                },
                {
                    path: 'export',
                    name: 'export',
                    component: () => import('../views/subscription/ExportView.vue')
                },
                {
                    path: 'archief',
                    name: 'archive',
                    component: () => import('../views/subscription/SubscriptionArchiveView.vue')
                },
            ]
        },
        // member routes --------------------------------------------------------
        {
            path: '/leden',
            name: 'members',
            component: () => import('../views/MemberView.vue')
        },
        {
            path: '/lid/:id',
            name: 'memberDetail',
            component: () => import('../views/MemberDetailView.vue'),
            props: (route) => {
                const id = castIdParameter(route.params.id.toString());
                return {id};
            },
        },
        {
            path: '/configuratie',
            name: 'member-configuration',
            component: () => import('../views/ConfigurationView.vue'),
            children: [
                {
                    path: 'periodes',
                    name: 'periods',
                    component: () => import('../views/configuration/PeriodView.vue')
                },
                {
                    path: 'graden',
                    name: 'grades',
                    component: () => import('../views/configuration/GradeView.vue')
                },
                {
                    path: 'groepen',
                    name: 'groups',
                    component: () => import('../views/configuration/GroupView.vue')
                },
                {
                    path: 'locaties',
                    name: 'locations',
                    component: () => import('../views/configuration/LocationView.vue')
                },
                {
                    path: 'settings',
                    name: 'settings',
                    component: () => import('../views/configuration/SettingsView.vue')
                },
            ]
        },
    ]
})

function castIdParameter(routeParamsId: string) {
    const id = Number.parseInt(routeParamsId, 10);
    if (Number.isNaN(id)) {
        return 0;
    }
    return id;
}

export default router
