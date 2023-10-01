/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {createRouter, createWebHashHistory} from 'vue-router'

const router = createRouter({
    history: createWebHashHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('../views/DashboardView.vue')
        },
        {
            path: '/inschrijvingen',
            name: 'inschrijvingen',
            component: () => import('../views/SubscriptionView.vue'),
            children: [
                {
                    path: 'web',
                    name: 'web',
                    component: () => import('../views/subscription/SubscriptionNew.vue')
                },
                {
                    path: 'te-betalen',
                    name: 'te-betalen',
                    component: () => import('../views/subscription/SubscriptionDuePayment.vue')
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
            path: '/leden-overzicht',
            name: 'membersOverview',
            component: () => import('../views/MemberOverview.vue')
        },
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
                    path: 'federaties',
                    name: 'federations',
                    component: () => import('../views/configuration/FederationsView.vue')
                },
                {
                    path: 'judogi',
                    name: 'judogi',
                    component: () => import('../views/configuration/JudogiView.vue')
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
