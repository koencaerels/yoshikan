<template>
    <div class="p-4">
        <div class="flex flex-row gap-4">
            <div class="basis-1/6">

                <div class="py-2">
                    <Button @click="appStore.loadConfiguration"
                            label="Refresh INFO"
                            icon="pi pi-refresh"
                            class="p-button-sm w-full"/>
                </div>

                <p class="font-bold">Algemeen</p>
                <p class="font-bold mt-2">{{appStore.dashboardNumbers.activePeriod.name}}</p>

                <p>Actieve leden: {{ appStore.dashboardNumbers.activeMembers }}</p>
                <p>Nog te betalen: {{ appStore.dashboardNumbers.duePayments }} €</p>
                <p>Total: {{ appStore.dashboardNumbers.totalAmount }} €</p>
                <div class="p-2">
                    <Chart type="doughnut" :data="chartDataFederations" :options="chartOptions" class="w-48"/>
                </div>
                <div class="p-2">
                    <Chart type="doughnut" :data="chartDataLocations" :options="chartOptions" class="w-48"/>
                </div>
            </div>
            <div class="basis-1/6">
                <div v-for="federationReport in appStore.dashboardNumbers.federationReports" class="mb-2">
                    <p class="font-bold text-xl">{{ federationReport.federation.name }}</p>
                    <p>Actieve leden: {{ federationReport.activeMembers }}</p>
                    <p>Nog te betalen: {{ federationReport.duePayments }} €</p>
                    <p>Total: {{ federationReport.totalAmount }} €</p>
                </div>
                <hr>
                <div class="mt-8">
                    <div v-if="appStore.dashboardNumbers.numberOfWebSubscriptions != 0" class="w-full">
                        <router-link to="/inschrijvingen/web"
                                     class="text-xs px-4 py-2 bg-yellow-300 w-full rounded-lg hover:bg-yellow-400 block font-bold">
                            {{appStore.dashboardNumbers.numberOfWebSubscriptions}} web inschrijvingen
                        </router-link>
                    </div>
                    <div class="mt-4 w-full" v-if="appStore.dashboardNumbers.numberOfDuePayments != 0" >
                        <router-link to="/inschrijvingen/te-betalen"
                                     class="text-xs px-4 py-2 bg-orange-300 w-full rounded-lg hover:bg-orange-400 block font-bold">
                        {{appStore.dashboardNumbers.numberOfDuePayments}} inschrijvingen nog te betalen
                        </router-link>
                    </div>
                </div>

<!--                <div class="mt-6">-->
<!--                    <div class="rounded-xl p-2 bg-blue-100">-->
<!--                        <a href="https://my.mollie.com/dashboard/" target="_blank">-->
<!--                            <div class="text-center"><img src="../assets/euro.png" width="50" class="mx-auto"></div>-->
<!--                            <div class="text-center">Mollie Dashboard</div>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->

            </div>
            <div class="basis-1/6 text-sm">
                <div v-for="locationReport in appStore.dashboardNumbers.locationReports" class="mb-2">
                    <p class="font-bold text-xl">{{ locationReport.location.name }}</p>
                    <p>Actieve leden: {{ locationReport.activeMembers }}</p>
                    <p>Nog te betalen: {{ locationReport.duePayments }} €</p>
                    <p>Total: {{ locationReport.totalAmount }} €</p>
                    <div class="mt-2">
                        <Button @click="downloadMemberList(locationReport.location.id)"
                                label="Download overzicht actieve leden"
                                icon="pi pi-download"
                                class="p-button-sm p-button-secondary"/>
                    </div>
                    <div @click="downloadMemberListAsExcel(locationReport.location.id)"
                        class="text-xs mt-2 text-blue-400 underline underline-offset-2 cursor-pointer">
                        (download als excel)
                    </div>
                    <hr class="mt-2">
                </div>
            </div>
            <div class="basis-1/6">
                <div>
                    <Button @click="downloadListDuePayments"
                            label="Print overzicht te betalen"
                            icon="pi pi-print"
                            class="p-button-sm p-button-primary w-full"/>
                </div>
                <div class="mt-4">
                    <Button @click="downloadEmptySubscriptionForm"
                            label="Print leeg inschrijfformulier"
                            icon="pi pi-print"
                            class="p-button-sm p-button-primary w-full"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {onMounted, ref, computed, watch} from "vue";
import {useMemberStore} from "@/store/member";

const appStore = useAppStore();
const memberStore = useMemberStore();
const chartDataLocations = ref();
const chartDataFederations = ref();
const chartOptions = ref({
    cutout: '50%'
});

const apiUrl = import.meta.env.VITE_API_URL;

onMounted(() => {
    chartDataLocations.value = setChartDataLocations();
    chartDataFederations.value = setChartDataFederations();
});

function downloadListDuePayments() {
    let url = apiUrl + '/member/overview-due-payments';
    window.open(url, '_blank');
}

function downloadMemberList(locationId) {
    let url = apiUrl + '/member/list/location/'+locationId;
    window.open(url, '_blank');
}

function downloadMemberListAsExcel(locationId) {
    let url = apiUrl + '/member/list/location/'+locationId+'/excel';
    window.open(url, '_blank');
}

function downloadEmptySubscriptionForm() {
    let url = apiUrl + '/subscriptions/print/empty';
    window.open(url, '_blank');
}

const subscriptionCounter = computed((): number => memberStore.refreshCounter);
watch(subscriptionCounter, (): void => {
    appStore.loadConfiguration();
    chartDataLocations.value = setChartDataLocations();
    chartDataFederations.value = setChartDataFederations();
});

const memberCounter = computed((): number => memberStore.memberCounter);
watch(memberCounter, (): void => {
    appStore.loadConfiguration();
    chartDataLocations.value = setChartDataLocations();
    chartDataFederations.value = setChartDataFederations();
});

const setChartDataLocations = () => {
    return {
        labels: appStore.dashboardNumbers.locationReports.map(item => item.location.name),
        datasets: [
            {
                data: appStore.dashboardNumbers.locationReports.map(item => item.activeMembers),
            },
        ]
    };
};

const setChartDataFederations = () => {
    return {
        labels: appStore.dashboardNumbers.federationReports.map(item => item.federation.name),
        datasets: [
            {
                data: appStore.dashboardNumbers.federationReports.map(item => item.activeMembers),
            }
        ]
    };
};

</script>
