<template>
    <div class="p-4">
        <div class="flex flex-row gap-4">
            <div class="basis-1/6">
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
                    <p class="font-bold">{{ federationReport.federation.name }}</p>
                    <p>Actieve leden: {{ federationReport.activeMembers }}</p>
                    <p>Nog te betalen: {{ federationReport.duePayments }} €</p>
                    <p>Total: {{ federationReport.totalAmount }} €</p>
                </div>

                <div class="mt-8">
                    <div v-if="appStore.dashboardNumbers.numberOfWebSubscriptions != 0">
                        <router-link to="/inschrijvingen/web"
                                     class="text-xs px-4 py-2 bg-yellow-300 w-full rounded-lg hover:bg-yellow-400">
                            {{appStore.dashboardNumbers.numberOfWebSubscriptions}} web inschrijvingen
                        </router-link>
                    </div>
                    <div class="mt-4" v-if="appStore.dashboardNumbers.numberOfDuePayments != 0">
                        <router-link to="/inschrijvingen/te-betalen"
                                     class="text-xs px-4 py-2 bg-orange-300 w-full rounded-lg hover:bg-orange-400">
                        {{appStore.dashboardNumbers.numberOfDuePayments}} inschrijvingen nog te betalen
                        </router-link>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="rounded-xl p-2 bg-blue-100">
                        <a href="https://my.mollie.com/dashboard/" target="_blank">
                            <div class="text-center"><img src="../assets/euro.png" width="100" class="mx-auto"></div>
                            <div class="text-center">Mollie Dashboard</div>
                        </a>
                    </div>
                </div>

            </div>
            <div class="basis-1/6 text-sm">
                <div v-for="locationReport in appStore.dashboardNumbers.locationReports" class="mb-2">
                    <p class="font-bold">{{ locationReport.location.name }}</p>
                    <p>Actieve leden: {{ locationReport.activeMembers }}</p>
                    <p>Nog te betalen: {{ locationReport.duePayments }} €</p>
                    <p>Total: {{ locationReport.totalAmount }} €</p>
                </div>
            </div>
            <div class="basis-1/4">
              &nbsp;
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

onMounted(() => {
    chartDataLocations.value = setChartDataLocations();
    chartDataFederations.value = setChartDataFederations();
});

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

<style scoped>

</style>
