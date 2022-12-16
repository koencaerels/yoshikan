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
            component: () => import('../views/ConfigurationView.vue')
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
