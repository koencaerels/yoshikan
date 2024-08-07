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
    <!-- header -->
    <div id="memberOverviewHeader" class="p-1 bg-gradient-to-r text-white" :class="headerColor">
        <div class="flex gap-2 py-1">
            <div class="">
                <div class="flex gap-2 ml-1">
                    <div v-if="(type === 'duePayment')">
                        <Button label="Afdrukken" @click="printSubscriptions"
                            :disabled="selectedSubscriptions.length === 0"
                            icon="pi pi-print"
                            class="p-button-sm p-button-warning"/>
                    </div>
                    <div>
                        <Button label="Exporteren" @click="downloadExport"
                                :disabled="selectedSubscriptions.length === 0"
                                icon="pi pi-file-excel"
                                class="p-button-sm p-button-warning"/>
                    </div>
                </div>
            </div>

            <div class="w-12"></div>

            <div class="flex-grow mt-0.5">
                <div class="p-input-icon-left w-full">
                    <i class="pi pi-search" />
                    <InputText v-model="filters['global'].value"
                               class="p-inputtext-sm w-full"
                               placeholder="zoek op trefwoord" />
                </div>
            </div>
            <div class="mt-0.5">
                <Button type="button" icon="pi pi-filter-slash"
                        class="p-button-sm p-button-secondary"
                        label="Verwijder alle filters"
                        @click="clearFilter()" />
            </div>

            <div class="flex-grow"></div>

            <div class="text-right">
                <Button @click="downloadListDuePayments" v-if="(type === 'duePayment')"
                        label="Download overzicht te betalen"
                        icon="pi pi-download"
                        class="p-button-sm p-button-secondary"/>
            </div>
        </div>
    </div>

    <!-- datatable -->
    <div>
        <DataTable :value="subscriptions"
                   v-model:filters="filters"
                   v-model:selection="selectedSubscriptions"
                   class="p-datatable-sm text-xs"
                   paginator :rows="20"
                   show-gridlines
                   filterDisplay="menu"
                   dataKey="id"
                   tableStyle="min-width: 50rem">

            <template #empty>
                <div class="p-4">
                    Geen inschrijvingen gevonden.
                </div>
            </template>
            <template #loading>
                <div class="p-2"><i class="pi pi-spin pi-spinner"></i></div>
            </template>
            <template #paginatorstart>
                <div>
                    <Button type="button" icon="pi pi-refresh" class="p-button-lg"
                            @click="subscriptionsOverviewStore.loadSubscriptions()"/>
                </div>
            </template>

            <Column selectionMode="multiple" headerStyle="width: 3rem" class="text-center"></Column>

            <!-- --------------------------------------------------------------------------------------------------- -->
            <!-- actions                                                                                             -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <Column field="isPrinted" data-type="boolean" sortable header="" class="text-xs" v-if="(type === 'duePayment')">
                <template #body="{ data }">
                    <div class="text-xs text-center">
                        <i class="pi pi-print" v-if="data.isPrinted"></i>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <TriStateCheckbox v-model="filterModel.value" @change="filterCallback()"/>
                </template>
            </Column>
            <Column field="isPaymentOverviewSend" data-type="boolean" sortable header="" v-if="(type === 'duePayment')"
                    class="text-xs">
                <template #body="{ data }">
                    <div class="text-xs text-center">
                        <i class="pi pi-send" v-if="data.isPaymentOverviewSend"></i>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <TriStateCheckbox v-model="filterModel.value" @change="filterCallback()"/>
                </template>
            </Column>

            <!-- --------------------------------------------------------------------------------------------------- -->
            <!-- details                                                                                             -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <Column field="id" sortable header="Ref." class="text-xs">
                <template #body="{data}">
                    <div v-if="memberStore.isLoading && subscriptionToLoad === data.id" class="text-center">
                        <i class="pi pi-spin pi-spinner"></i>
                    </div>
                    <div v-else>
                        <subscription-badge @click="showSubscriptionDetailFn(data)"
                                            :subscription="data" class="w-[5rem] cursor-pointer"/>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="zoek op nummer"/>
                </template>
            </Column>
            <Column field="status" sortable header="Status" class="text-xs">
                <template #body="{data}">
                    <subscription-status @click="showSubscriptionDetailFn(data)" class="cursor-pointer"
                                         :subscription="data"/>
                </template>
            </Column>
            <Column field="type" sortable header="Type" class="text-xs">
                <template #body="{data}">
                    <subscription-type @click="showSubscriptionDetailFn(data)" class="cursor-pointer"
                                       :subscription="data"/>
                </template>
            </Column>
            <Column field="total" sortable header="Bedrag" class="text-sm">
                <template #body="{data}">
                    <div class="font-bold cursor-pointer" @click="showSubscriptionDetailFn(data)">
                        {{ data.total }} €
                    </div>
                </template>
            </Column>

            <Column field="memberId" sortable header="Lidnr." class="text-xs" style="border-left:1px solid black;">
                <template #body="{data}">
                    <div v-if="memberStore.isMemberLoading && memberStore.memberId === data.memberId"
                         class="text-center">
                        <i class="pi pi-spin pi-spinner"></i>
                    </div>
                    <div v-else class="text-gray-500 text-center ml-2">
                        <div v-if="data.memberId !== null"
                             @click="showDetailDialogFullFn(data.memberId)"
                             class="text-center rounded-full bg-blue-900 text-white px-2 font-bold text-xs w-[5rem] cursor-pointer">
                            YK-{{ data.memberId }}
                        </div>
                    </div>
                </template>
            </Column>
            <Column field="lastname" sortable header="Naam" class="text-xs">
                <template #body="{ data }">
                    <div @click="showDetailDialogFullFn(data.memberId)"
                         class="text-base uppercase font-bold text-sm p-1 cursor-pointer">
                        {{ data.lastname }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="zoek op naam"/>
                </template>
            </Column>
            <Column field="firstname" sortable header="Voornaam" class="text-xs">
                <template #body="{ data }">
                    <div @click="showDetailDialogFullFn(data.memberId)"
                         class="text-base font-bold text-sm cursor-pointer">
                        {{ data.firstname }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="zoek op naam"/>
                </template>
            </Column>

            <Column field="dateOfBirth" sortable header="Geboorted." class="text-xs">
                <template #body="{ data }">
                    <div class="flex gap-2" @click="showDetailDialogFullFn(data.memberId)">
                        <div class="text-xs">
                            ° {{ moment(data.dateOfBirth).format("DD/MM/YYYY") }}
                            - {{ data.gender }}
                        </div>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="zoek op geboorte datum"/>
                </template>
            </Column>

            <Column field="location.name" sortable header="Locatie" class="text-xs no-padding">
                <template #body="{ data }">
                    <div class="text-xs cursor-pointer p-1" @click="showDetailDialogFullFn(data.memberId)">
                        {{ data.location.name }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <Dropdown class="w-full" v-if="appStore.configuration"
                              @input="filterCallback()"
                              v-model="filterModel.value"
                              :show-clear="true"
                              placeholder="selecteer een locatie"
                              option-label="name" option-value="code"
                              :options="appStore.configuration.locations"/>
                </template>
            </Column>

            <!-- --------------------------------------------------------------------------------------------------- -->
            <!-- lidgeld                                                                                             -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <Column field="memberSubscriptionStart" style="border-left:1px solid black;" sortable header="lid tot"
                    class="text-xs">
                <template #body="{ data }">
                    <div class="text-xs text-center font-bold">
                        {{ moment(data.memberSubscriptionEnd).format("MM / YYYY") }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value"
                               type="text"
                               @input="filterCallback()"
                               class="p-column-filter"
                               placeholder="tot"/>
                </template>
            </Column>

            <!-- --------------------------------------------------------------------------------------------------- -->
            <!-- vergunning                                                                                          -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <Column field="federation.code" sortable header="Fed." class="text-xs no-padding"
                    style="border-left:1px solid black">
                <template #body="{ data }">
                    <div class="text-xs text-center">
                        {{ data.federation.code }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <Dropdown class="w-full" v-if="appStore.configuration"
                              @input="filterCallback()"
                              v-model="filterModel.value"
                              :show-clear="true"
                              placeholder="selecteer een federatie"
                              option-label="name" option-value="code"
                              :options="appStore.configuration.federations"/>
                </template>
            </Column>
            <Column field="licenseEnd" sortable header="tot"
                    class="text-xs">
                <template #body="{ data }">
                    <div class="text-xs text-center font-bold">
                        {{ moment(data.licenseEnd).format("MM / YYYY") }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value"
                               type="text"
                               @input="filterCallback()"
                               class="p-column-filter"
                               placeholder="tot"/>
                </template>
            </Column>
        </DataTable>
    </div>

    <!-- subscription detail --------------------------------------------------------------------------------------- -->
    <Dialog v-model:visible="showSubscriptionDetail"
            v-if="memberStore.subscriptionDetail"
            :header="'Detail van de inschrijving: YKS-'+memberStore.subscriptionDetail.id"
            :modal="true">
        <subscription-detail
            v-on:subscription-changed="hideSubscriptionDetailFn"
            v-on:paid="hideSubscriptionDetailFn"
            v-on:finished="hideSubscriptionDetailFn"
            v-on:subscription-reviewed="hideSubscriptionDetailFn"
            v-on:canceled="hideSubscriptionDetailFn"/>
    </Dialog>

    <!-- member detail --------------------------------------------------------------------------------------------- -->
    <Dialog v-model:visible="showDialogFullDetail"
            v-if="memberStore.memberDetail"
            position="top"
            :header="memberStore.memberDetail.lastname.toUpperCase()+' '+memberStore.memberDetail.firstname"
            :modal="true">
        <div style="width: 1350px;">
            <Splitter>
                <SplitterPanel :size="50">
                    <member-detail :type="'dialog'" estate-height="500"/>
                </SplitterPanel>
                <SplitterPanel :size="50">
                    <member-images/>
                </SplitterPanel>
            </Splitter>
        </div>
    </Dialog>

</template>

<script setup lang="ts">
import type {Subscription} from "@/api/query/model";
import {useAppStore} from "@/store/app";
import {useSubscriptionOverviewStore} from "@/store/subscriptionOverview";
import {computed, onMounted, ref} from "vue";
import {FilterMatchMode} from "primevue/api";
import SubscriptionBadge from "@/components/subscription/common/subscriptionBadge.vue";
import SubscriptionStatus from "@/components/subscription/common/subscriptionStatus.vue";
import SubscriptionType from "@/components/subscription/common/subscriptionType.vue";
import SubscriptionDetail from "@/components/subscription/detail/subscriptionDetail.vue";
import moment from "moment";
import {useMemberStore} from "@/store/member";
import MemberImages from "@/components/member/memberImages.vue";
import MemberDetail from "@/components/member/memberDetail.vue";

const props = defineProps<{
    subscriptions: Array<Subscription>,
    type: 'new' | 'duePayment' | 'archive',
}>();

const apiUrl = import.meta.env.VITE_API_URL as string;
const appStore = useAppStore();
const subscriptionsOverviewStore = useSubscriptionOverviewStore();
const memberStore = useMemberStore();

// -- datatable --------------------------------------------------------------------------------------------------------

const selectedSubscriptions = ref<Array<Subscription>>([]);

onMounted((): void => {
    initFilters();
});

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        id: {value: null, matchMode: FilterMatchMode.CONTAINS},
        firstname: {value: null, matchMode: FilterMatchMode.CONTAINS},
        lastname: {value: null, matchMode: FilterMatchMode.CONTAINS},
        'location.name': {value: null, matchMode: FilterMatchMode.EQUALS},
        memberSubscriptionEnd: {value: null, matchMode: FilterMatchMode.CONTAINS},
        'federation.code': {value: null, matchMode: FilterMatchMode.EQUALS},
        licenseEnd: {value: null, matchMode: FilterMatchMode.CONTAINS},
        isPrinted: {value: null, matchMode: FilterMatchMode.EQUALS},
        isPaymentOverviewSend: {value: null, matchMode: FilterMatchMode.EQUALS},
    };
};

function clearFilter() {
    initFilters();
}

// -- button actions ---------------------------------------------------------------------------------------------------

function downloadExport() {
    let url = apiUrl + '/subscriptions/export?ids=' + selectedIds.value.toString();
    window.open(url, '_blank');
}

function printSubscriptions() {
    let url = apiUrl + '/subscriptions/print?ids=' + selectedIds.value.toString();
    window.open(url, '_blank');
}

// -- detail dialogs ---------------------------------------------------------------------------------------------------

const subscriptionToLoad = ref<number>(0);
const showSubscriptionDetail = ref<boolean>(false);

async function showSubscriptionDetailFn(subscription: Subscription) {
    subscriptionToLoad.value = subscription.id;
    await memberStore.loadSubscriptionDetail(subscription.id);
    showSubscriptionDetail.value = true;
}

function hideSubscriptionDetailFn() {
    showSubscriptionDetail.value = false;
    subscriptionsOverviewStore.loadSubscriptions();
}

const showDialogFullDetail = ref<boolean>(false);

async function showDetailDialogFullFn(id: number): void {
    if(id) {
        await memberStore.loadMemberDetail(id);
        showDialogFullDetail.value = true;
    }
}

function downloadListDuePayments() {
    let url = apiUrl + '/member/overview-due-payments';
    window.open(url, '_blank');
}

// -- computed properties ----------------------------------------------------------------------------------------------

const headerColor = computed((): string => {
    switch (props.type) {
        case "archive":
            return "from-green-600 to-green-400";
        case "duePayment":
            return "from-orange-600 to-orange-400";
        default:
            return "from-yellow-600 to-yellow-400";
    }
});

const selectedIds = computed((): number[] => {
    let result = [];
    for (let subscription of selectedSubscriptions.value) {
        result.push(subscription.id);
    }
    return result;
});

</script>
