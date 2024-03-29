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
    <navigation v-if="twoFactorStore.isCodeValid" />

    <!-- -- router view ---------------------------------------- -->
    <div v-if="appStore.isConfigurationLoaded">
        <RouterView v-slot="{ Component }">
            <KeepAlive>
                <component :is="Component"/>
            </KeepAlive>
        </RouterView>
    </div>
    <div v-else>
        <div id="background">
            <div class="mx-auto my-auto text-gray-400" style="width:50px;">
                <br><br><br>
                <ProgressSpinner/>
            </div>
        </div>
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
import {useTwoFactorStore} from "@/store/twoFactor";

const toaster = useToast();
const app = getCurrentInstance();
const progress = app?.appContext.config.globalProperties.$Progress ?? '';
const router = useRouter();
const appStore = useAppStore();
const twoFactorStore = useTwoFactorStore();

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

<style scoped>

#background {
    position: fixed;
    top: 0;
    left: 67px;
    right: 0;
    bottom: 0;
    background-color: #A6B7C8;
}

</style>
