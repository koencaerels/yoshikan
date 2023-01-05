<template>
    <div id="subscriptionArchive">

        <!-- filter ------------------------------------------------------------------ -->
        <div>
            <form v-on:submit.prevent>
                <div class="flex text-sm bg-gray-200 p-2">
                    <div>
                        <Button icon="pi pi-refresh"
                                @click="filterItems"
                                class="p-button-sm p-button-outlined"/>
                    </div>
                    <div class="w-32 ml-2">
                        <InputText class="w-full p-inputtext-sm" placeholder="keyword"
                                   v-model="searchModel.keyword"/>
                    </div>
                    <div class="w-64 ml-2">
                        <Dropdown class="w-full" v-if="appStore.configuration"
                                  placeholder="seizoen"
                                  :show-clear="true"
                                  option-label="name"
                                  option-value="id"
                                  v-model="searchModel.periodId"
                                  :options="appStore.configuration.periods"/>
                    </div>
                    <div class="w-64 ml-2">
                        <Dropdown class="w-full"
                                  placeholder="status"
                                  :show-clear="true"
                                  v-model="searchModel.status"
                                  :options="status"/>
                    </div>
                    <div class="w-48 ml-2">
                        <Dropdown class="w-full" v-if="appStore.configuration"
                                  :show-clear="true"
                                  placeholder="plaats"
                                  v-model="searchModel.locationId"
                                  option-label="name" option-value="id"
                                  :options="appStore.configuration.locations"/>
                    </div>
                    <div class="ml-2">
                        <Button label="Filter" type="submit"
                                @click="filterItems"
                                class="p-button-sm w-full" icon="pi pi-filter"/>
                    </div>
                    <div class="ml-2">
                        <Button label="Reset"
                                @click="resetFilter"
                                class="p-button-sm w-full p-button-outlined" icon="pi pi-times"/>
                    </div>
                </div>
            </form>
        </div>

        <!-- header ------------------------------------------------------------------------- -->
        <div class="flex bold p-2 border-b-[1px] border-black text-xs font-bold">
            <div class="ml-2 w-16">Ref.</div>
            <div class="ml-2 w-32">Seizoen</div>
            <div class="ml-2 w-48">Status</div>
            <div class="ml-2 w-48">Naam</div>
            <div class="ml-2 w-16">Lidnr.</div>
            <div class="ml-2 w-32">Geboortedatum</div>
            <div class="ml-2 w-16">Geslacht</div>
            <div class="ml-2">Locatie</div>
        </div>

        <!-- list ------------------------------------------------------------------------- -->
        <list-wrapper :estate-height="260">
            <div>
                <!-- row -->
                <div v-for="subscription in listItems"
                     class="flex p-2 text-xs border-b-[1px] border-gray-300 hover:bg-gray-100">
                    <div class="ml-2 w-16">YKS-{{ subscription.id }}</div>
                    <div class="ml-2 w-32">{{ subscription.period.name }}</div>
                    <div class="ml-2 w-48">
                        <div class="bg-green-400 rounded-full px-2 text-xs text-center w-[10rem] font-bold">
                            {{ subscription.status }}
                        </div>
                    </div>
                    <div class="ml-2 w-48 font-bold">{{ subscription.firstname }} {{ subscription.lastname }}</div>
                    <div class="ml-2 w-16">
                        <div v-if="subscription.member">
                            <div class="bg-blue-900 text-white rounded-full px-2 text-xs text-center">
                                YK-{{ subscription.member.id }}
                            </div>
                        </div>
                        <div v-else>n/a</div>
                    </div>
                    <div class="ml-2 w-32">° {{ moment(subscription.dateOfBirth).format("DD/MM/YYYY") }}</div>
                    <div class="ml-2 w-16">{{ subscription.gender }}</div>
                    <div class="ml-2">{{ subscription.location.name }}</div>
                </div>
            </div>
        </list-wrapper>

    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {useMemberStore} from "@/store/member";
import {onMounted, ref} from "vue";
import type {Subscription} from "@/api/query/model";
import ListWrapper from "@/components/wrapper/listWrapper.vue";
import moment from "moment";

const appStore = useAppStore();
const memberStore = useMemberStore();
const status = ['nieuw', 'wachtend op betaling', 'betaald', 'afgewerkt', 'afgewezen'];
const searchModel = ref({
    keyword: '',
    locationId: null,
    periodId: null,
    status: null,
});
const listItems = ref<Subscription[]>([]);

onMounted(() => {
    void filterItems();
});

function resetFilter() {
    searchModel.value = {
        keyword: '',
        locationId: null,
        periodId: null,
        status: null,
    }
    filterItems();
}

async function filterItems() {
    await memberStore.loadSubscriptionsArchive();
    let result = [];
    if (searchModel.value.keyword.length === 0
        && searchModel.value.locationId === null
        && searchModel.value.periodId === null
        && searchModel.value.status === null) {
        result = memberStore.subscriptionsArchive;
    } else {
        const filterValue = searchModel.value.keyword.toLowerCase();
        let conditions: any = [];
        if (searchModel.value.keyword.length !== 0) {
            conditions.push((event: { id:number; contactFirstname: string; contactLastname: string; firstname: string; lastname: string; contactEmail: string; }) => (event.contactFirstname.toLowerCase().includes(filterValue)
                || event.contactLastname.toLowerCase().includes(filterValue)
                || event.firstname.toLowerCase().includes(filterValue)
                || event.lastname.toLowerCase().includes(filterValue)
                || event.contactEmail.toLowerCase().includes(filterValue)
                || event.id.toString().toLowerCase().includes(filterValue)
            ));
        }
        if (searchModel.value.locationId) {
            conditions.push((event: { location: { id: null; }; }) => event.location.id === searchModel.value.locationId);
        }
        if (searchModel.value.periodId) {
            conditions.push((event: { period: { id: null; }; }) => event.period.id === searchModel.value.periodId);
        }
        if (searchModel.value.status) {
            conditions.push((event: { status: null; }) => event.status === searchModel.value.status);
        }
        result = memberStore.subscriptionsActivePeriod.filter(o => conditions.every((c: any) => c(o)));
    }
    listItems.value = result;
}

</script>
