<!--
/*
* This file is part of the Yoshi-Kan software.
*
* (c) Koen Caerels
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
-->

<template>

    <!-- -- progress bar --------------------------------------- -->
    <vue-progress-bar/>

    <!-- -- navigation ----------------------------------------- -->
    <navigation/>

    <!-- -- router view ---------------------------------------- -->
    <div v-if="appStore.isConfigurationLoaded">
        <RouterView v-slot="{ Component }">
            <KeepAlive>
                <component :is="Component"/>
            </KeepAlive>
        </RouterView>
    </div>

    <!-- -- toaster -------------------------------------------- -->
    <Toast position="bottom-right"/>

</template>

<script setup lang="ts">
import {getCurrentInstance, onMounted} from "vue";
import axios from "axios";
import {useToast} from "primevue/usetoast";
import {useRouter} from "vue-router";
import Navigation from "@/components/Navigation.vue";
import {useAppStore} from "@/store/app";

const toaster = useToast();
const app = getCurrentInstance();
const progress = app?.appContext.config.globalProperties.$Progress ?? '';
const router = useRouter();
const appStore = useAppStore();

/* eslint-disable no-unused-vars */
router.beforeEach((to, from, next) => {
    progress.start();
    next();
});
router.afterEach((to, from) => {
    progress.finish();
});
/* eslint-enable no-unused-vars */

onMounted((): void => {
    // -- load the configuration
    loadConfiguration();

    // -- some error feedback for the user
    axios.interceptors.response.use(
        response => {
            progress.finish();
            return response;
        }
        , function (error) {
            toaster.add({
                severity: "error",
                summary: "Oeps, er is iets misgelopen.",
                detail: "Gelieve de webmaster te contacteren.",
                life: 3000,
            });
            progress.fail();
            return Promise.reject(error);
        }
    );

    axios.interceptors.request.use((request) => {
        progress.start();
        return request;
    });

});

async function loadConfiguration() {
    await appStore.loadConfiguration();
}

</script>
