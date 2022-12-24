<template>
    <div id="subscriptionsToDo">
        <div class="p-2 bg-gray-200 text-sm">
            <div class="flex flex-row">
                <div class="basis-1/3 text-right mr-2">Periode</div>
                <div class="basis-2/3">
                    <strong v-if="appStore.configuration">
                        {{ appStore.configuration.activePeriod.name }}
                    </strong>
                </div>
            </div>
            <form v-on:submit.prevent>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Naam</div>
                    <div class="basis-2/3">
                        <InputText class="w-full p-inputtext-sm"
                                   v-model="searchModel.keyword"/>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Status</div>
                    <div class="basis-2/3">
                        <Dropdown class="w-full"
                                  :show-clear="true"
                                  v-model="searchModel.status"
                                  :options="status"/>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Locatie</div>
                    <div class="basis-2/3">
                        <Dropdown class="w-full" v-if="appStore.configuration"
                                  :show-clear="true"
                                  v-model="searchModel.locationId"
                                  option-label="name" option-value="id"
                                  :options="appStore.configuration.locations"/>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/2 text-right mr-2">
                        <Button class="p-button-sm p-button-secondary w-full"
                                icon="pi pi-plus" @click="addSubscription"
                                label="Nieuwe inschrijving"/>
                    </div>
                    <div class="basis-1/2 text-right">
                        <Button label="Zoek in de inschrijvingen" type="submit"
                                @click="filterTodoItems"
                                class="p-button-sm w-full" icon="pi pi-filter"/>
                    </div>
                </div>
            </form>
        </div>

        <!-- -- dialog new subscription -->
        <Dialog v-model:visible="showNewSubscription" position="topleft" v-if="appStore.configuration"
                :header="'Voeg een inschrijving toe voor '+appStore.configuration.activePeriod.name"
                :modal="true">
            <subscription-add v-on:subscribed="subscribeHandler"/>
        </Dialog>

        <!-- -- list -->
        <list-wrapper :estate-height="370">
            <div v-for="subscription in todoItems">
                <div class="m-2 p-2 border-2 rounded-xl bg-white hover:bg-indigo-100">
                    <div class="flex flex-row-reverse">
                        <edit-button @click="loadDetail(subscription.id)"></edit-button>
                        <div class="w-full">
                            <div class="flex">
                                <subscription-tag :subscription="subscription"/>
                            </div>
                            <div class="mt-2 text-xl">
                                <strong>{{ subscription.firstname }} {{ subscription.lastname }}</strong>
                                (° {{ moment(subscription.dateOfBirth).format("DD/MM/YYYY") }}
                                - {{ subscription.gender }}
                                )
                            </div>
                            <div>
                                <span v-if="subscription.isNewMember" class="mr-4">Nieuw lid</span>
                                <span v-if="subscription.isJudogiBelt">Judo pak + gordel</span>
                            </div>
                            <div class="flex border-t-[1px] mt-2 pt-2">
                                <div class="px-2 bg-sky-400 rounded-full text-white text-xs w-32 text-center">
                                    {{ subscription.location.name }}
                                </div>
                                <div class="ml-2 text-xs">
                                    Contact:
                                    <strong>
                                        {{ subscription.contactFirstname }}
                                        {{ subscription.contactLastname }}
                                    </strong>
                                    [{{ subscription.contactEmail }}]
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </list-wrapper>
    </div>
</template>

<script setup lang="ts">
import ListWrapper from "@/components/wrapper/listWrapper.vue";
import {useAppStore} from "@/store/app";
import {onMounted, ref} from "vue";
import SubscriptionAdd from "@/components/subscription/subscriptionAdd.vue";
import {useMemberStore} from "@/store/member";
import type {Subscription} from "@/api/query/model";
import EditButton from "@/components/common/editButton.vue";
import moment from "moment";
import SubscriptionTag from "@/components/subscription/subscriptionTag.vue";

const appStore = useAppStore();
const memberStore = useMemberStore();
const status = ['nieuw', 'wachtend op betaling', 'betaald'];
const searchModel = ref({
    keyword: '',
    locationId: null,
    status: null,
});
const showNewSubscription = ref<boolean>(false);
const todoItems = ref<Subscription[]>([]);

onMounted(() => {
    void filterTodoItems();
});

async function filterTodoItems() {
    await memberStore.loadSubscriptionTodo();
    let result = [];
    if (searchModel.value.keyword.length === 0
        && searchModel.value.locationId === null
        && searchModel.value.status === null) {
        result = memberStore.subscriptionTodos;
    } else {
        const filterValue = searchModel.value.keyword.toLowerCase();
        let conditions: any = [];
        if (searchModel.value.keyword.length !== 0) {
            conditions.push((event: { contactFirstname: string; contactLastname: string; firstname: string; lastname: string; contactEmail: string; }) => (event.contactFirstname.toLowerCase().includes(filterValue)
                || event.contactLastname.toLowerCase().includes(filterValue)
                || event.firstname.toLowerCase().includes(filterValue)
                || event.lastname.toLowerCase().includes(filterValue)
                || event.contactEmail.toLowerCase().includes(filterValue)
            ));
        }
        if (searchModel.value.locationId) {
            conditions.push((event: { location: { id: null; }; }) => event.location.id === searchModel.value.locationId);
        }
        if (searchModel.value.status) {
            conditions.push((event: { status: null; }) => event.status === searchModel.value.status);
        }

        result = memberStore.subscriptionTodos.filter(o => conditions.every((c: any) => c(o)));
    }
    todoItems.value = result;
}

function addSubscription() {
    showNewSubscription.value = true;
}

function subscribeHandler() {
    showNewSubscription.value = false;
    searchModel.value.keyword = '';
    searchModel.value.locationId = null;
    searchModel.value.status = null;
    filterTodoItems();
}

function loadDetail(id: number) {
    memberStore.loadSubscriptionDetail(id);
}

</script>
