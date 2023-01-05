<template>
    <div id="subscriptionExport">
        <!-- filter -->
        <div>
            <form v-on:submit.prevent>
                <div class="flex text-sm bg-gray-200 p-2">
                    <div>
                        <Button icon="pi pi-refresh"
                                @click="filterItems"
                                class="p-button-sm p-button-outlined"/>
                    </div>
                    <div class="mt-2 ml-2">
                        <strong v-if="appStore.configuration">
                            {{ appStore.configuration.activePeriod.name }}
                        </strong>
                    </div>
                    <div class="w-64 ml-4">
                        <Dropdown class="w-full"
                                  :show-clear="true"
                                  v-model="searchModel.status"
                                  v-on:change="filterItems"
                                  :options="status"/>
                    </div>
                </div>
            </form>
        </div>

        <!-- list -->
        <div class="flex bold p-2 border-b-[1px] border-black text-sm font-bold">
            <div class="w-8">
                <Checkbox v-model="selectAll"
                          v-on:change="changeAllCheckBox"
                          name="selectAll" :binary="true"/>
            </div>
            <div class="ml-2 w-16">Ref.</div>
            <div class="ml-2 w-48">Status</div>
            <div class="ml-2 w-48">Naam</div>
            <div class="ml-2 w-16">Lidnr.</div>
            <div class="ml-2 w-32">Geboortedatum</div>
            <div class="ml-2 w-16">Geslacht</div>
            <div class="ml-2">Contact</div>
        </div>

        <list-wrapper :estate-height="294">
            <div>
                <!-- row -->
                <div v-for="subscription in listItems"
                     class="flex p-2 text-sm border-b-[1px] border-gray-300 hover:bg-gray-100">
                    <div class="w-8">
                        <Checkbox :binary="true"
                                  v-model="subscription.selected"/>
                    </div>
                    <div class="ml-2 w-16">
                        YKS-{{ subscription.id }}
                    </div>
                    <div class="ml-2 w-48">
                        <div class="bg-green-400 rounded-full px-2 text-xs text-center w-[10rem] font-bold">
                            {{ subscription.status }}
                        </div>
                    </div>
                    <div class="ml-2 w-48 font-bold">
                        {{ subscription.firstname }} {{ subscription.lastname }}
                    </div>
                    <div class="ml-2 w-16">
                        <div v-if="subscription.member">
                            <div class="bg-blue-900 text-white rounded-full px-2 text-xs text-center">
                                YK-{{ subscription.member.id }}
                            </div>
                        </div>
                        <div v-else>
                            n/a
                        </div>
                    </div>
                    <div class="ml-2 w-32">
                        ° {{ moment(subscription.dateOfBirth).format("DD/MM/YYYY") }}
                    </div>
                    <div class="ml-2 w-16">
                        {{ subscription.gender }}
                    </div>
                    <div class="ml-2">
                        {{ subscription.contactFirstname }} {{ subscription.contactLastname }}
                        ({{ subscription.contactEmail }})
                    </div>
                </div>
            </div>
        </list-wrapper>

        <div class="flex text-sm bg-gray-200 p-2">
            <div>
                <Button label="Exporteer selectie"
                        @click="downloadExport"
                        :disabled="(selectedIds.length === 0)"
                        class="p-button-sm p-button-secondary"
                        icon="pi pi-file-excel"/>
            </div>
            <div class="ml-4" v-if="searchModel.status === 'betaald'">
                <Button
                    v-if="!isSaving"
                    :disabled="(selectedIds.length === 0)"
                    label="Duid selectie aan als afgewerkt."
                    @click="markSubscriptionsAsFinishedHandler"
                    class="p-button-sm p-button-success" icon="pi pi-save"/>
                <Button
                    v-else disabled
                    label="Duid selectie aan als afgewerkt."
                    class="p-button-sm p-button-success" icon="pi pi-spinner pi-spin"/>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import moment from "moment";
import {useAppStore} from "@/store/app";
import {useMemberStore} from "@/store/member";
import {computed, onMounted, ref, watch} from "vue";
import type {Subscription} from "@/api/query/model";
import ListWrapper from "@/components/wrapper/listWrapper.vue";
import type {MarkSubscriptionsAsFinishedCommand} from "@/api/command/markSubscriptionsAsFinished";
import {markSubscriptionsAsFinished} from "@/api/command/markSubscriptionsAsFinished";
import {useToast} from "primevue/usetoast";

const apiUrl = import.meta.env.VITE_API_URL as string;
const appStore = useAppStore();
const memberStore = useMemberStore();
const status = ['nieuw', 'wachtend op betaling', 'betaald', 'afgewerkt', 'afgewezen'];
const searchModel = ref({status: 'betaald'});
const listItems = ref<Subscription[]>([]);
const selectAll = ref<boolean>(false);
const toaster = useToast();

onMounted(() => {
    void filterItems();
});

function downloadExport() {
    let url = apiUrl + '/subscriptions/export?ids=' + selectedIds.value.toString();
    window.open(url, '_blank');
}

async function filterItems() {
    await memberStore.loadSubscriptionsByActivePeriod();
    let result = [];
    if (searchModel.value.status === null) {
        result = memberStore.subscriptionsActivePeriod;
    } else {
        let conditions: any = [];
        if (searchModel.value.status) {
            conditions.push((event: { status: null; }) => event.status === searchModel.value.status);
        }
        result = memberStore.subscriptionsActivePeriod.filter(o => conditions.every((c: any) => c(o)));
    }
    listItems.value = result;
    selectAll.value = false;
    deselectAllItems();
}

const selectedIds = computed((): number[] => {
    let result = [];
    for (let subscription of listItems.value) {
        if (subscription.selected) {
            result.push(subscription.id)
        }
    }
    return result;
});

function changeAllCheckBox() {
    if (selectAll.value) {
        selectAllItems()
    } else {
        deselectAllItems()
    }
}

function selectAllItems() {
    for (let subscription of listItems.value) {
        subscription.selected = true;
    }
}

function deselectAllItems() {
    for (let subscription of listItems.value) {
        subscription.selected = false;
    }
}

// -- change selection to finished ---------------------------------

const isSaving = ref<boolean>(false);

async function markSubscriptionsAsFinishedHandler() {
    isSaving.value = true;
    let command: MarkSubscriptionsAsFinishedCommand = {listIds: selectedIds.value};
    let result = await markSubscriptionsAsFinished(command);
    searchModel.value.status = 'afgewerkt';
    await filterItems();
    await memberStore.loadSubscriptionTodo();
    memberStore.increaseCounter();
    toaster.add({
        severity: "success",
        summary: "Inschrijvingen zijn afgewerkt.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    isSaving.value = false;
}

</script>
