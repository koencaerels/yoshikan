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
    <div id="memberOverviewHeader" class="p-2 bg-gradient-to-r from-slate-600 to-slate-200 text-white">
        Header
    </div>
    <div>
        <DataTable :value="memberOverviewStore.members"
                   v-model:filters="filters"
                   class="p-datatable-sm text-xs"
                   paginator :rows="15"
                   showGridlines
                   filterDisplay="menu"
                   dataKey="id"
                   selectionMode="single"
                   tableStyle="min-width: 50rem">

            <template #empty> Geen leden gevonden.</template>
            <template #loading> Loading member data. Please wait.</template>
            <template #paginatorstart>
                <Button type="button" icon="pi pi-refresh" text @click="loadActiveMembers"/>
            </template>

            <!-- --------------------------------------------------------------------------------------------------- -->
            <!-- personalia -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <Column field="id" sortable header="Lidnr." class="text-xs">
                <template #body="{data}">
                    <div @click="showDetailDialogFullFn(data.id)"
                         class="text-center rounded-full bg-blue-900 text-white px-2 font-bold text-xs w-[4rem]">
                        YK-{{ data.id }}
                    </div>
                </template>
            </Column>
            <Column field="lastname" sortable header="Naam" class="text-xs">
                <template #body="{ data }">
                    <div @click="showDetailDialogFullFn(data.id)" class="text-base uppercase">{{ data.lastname }}</div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="zoek op naam"/>
                </template>
            </Column>
            <Column field="firstname" sortable header="Voornaam" class="text-xs">
                <template #body="{ data }">
                    <div class="text-base" @click="showDetailDialogFullFn(data.id)">{{ data.firstname }}</div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="zoek op naam"/>
                </template>
            </Column>
            <Column field="dateOfBirth" sortable header="Geboortedatum" class="text-xs">
                <template #body="{ data }">
                    <div class="text-xs" @click="showDetailDialogFullFn(data.id)">
                        ° {{ moment(data.dateOfBirth).format("DD/MM/YYYY") }}
                        - {{ data.gender }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="zoek op geboorte datum"/>
                </template>
            </Column>
            <Column field="grade" sortable header="Graad" class="text-xs">
                <template #body="slotProps">
                    <div class="text-white rounded-full text-xs px-2 text-center"
                         :style="'background-color:#'+slotProps.data.grade.color">
                        {{ slotProps.data.grade.name }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="zoek op graad"/>
                </template>
            </Column>
            <Column field="location.name" sortable header="Locatie" class="text-xs">
                <template #body="slotProps">
                    <div class="text-xs w-[7rem]">
                        {{ slotProps.data.location.name }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="zoek op locatie"/>
                </template>
            </Column>
            <Column field="memberAction" header="actie" class="text-xs">
                <template #body="{ data }">
                    <div v-if="memberStore.isMemberLoading && memberStore.memberId === data.id" class="text-center">
                        <i class="pi pi-spin pi-spinner"></i>
                    </div>
                    <div v-else class="text-gray-500 text-center ml-2">
                        <small-edit-button @click="showDetailDialogFn(data.id)"/>
                    </div>
                </template>
            </Column>

            <!-- --------------------------------------------------------------------------------------------------- -->
            <!-- lidgeld -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <Column field="memberSubscriptionStart" style="border-left:1px solid black" sortable header="van"
                    class="text-xs">
                <template #body="{ data }">
                    <div class="text-xs">
                        {{ moment(data.memberSubscriptionStart).format("MM / YYYY") }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="van"/>
                </template>
            </Column>
            <Column field="memberSubscriptionEnd" sortable header="tot" class="text-xs">
                <template #body="{ data }">
                    <div class="text-xs">
                        {{ moment(data.memberSubscriptionEnd).format("MM / YYYY") }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="tot"/>
                </template>
            </Column>
            <Column field="memberSubscriptionIsPayed" data-type="boolean" sortable header="betaald" class="text-xs">
                <template #body="{ data }">
                    <div class="text-center">
                        <i class="pi"
                           :class="{ 'pi-check-circle text-green-500': data.memberSubscriptionIsPayed, 'pi-times-circle text-red-400': !data.memberSubscriptionIsPayed }"></i>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <TriStateCheckbox v-model="filterModel.value" @change="filterCallback()"/>
                </template>
            </Column>
            <Column field="membershipAction" header="actie" class="text-xs"></Column>

            <!-- --------------------------------------------------------------------------------------------------- -->
            <!-- vergunning -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <Column field="federation.code" sortable header="Fed." class="text-xs" style="border-left:1px solid black">
                <template #body="{ data }">
                    <div>{{ data.federation.code }}</div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="zoek op federatie"/>
                </template>
            </Column>
            <Column field="licenseStart" sortable header="van" class="text-xs">
                <template #body="{ data }">
                    <div class="text-xs">
                        {{ moment(data.licenseStart).format("MM / YYYY") }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="van"/>
                </template>
            </Column>
            <Column field="licenseEnd" sortable header="tot" class="text-xs">
                <template #body="{ data }">
                    <div class="text-xs">
                        {{ moment(data.licenseEnd).format("MM / YYYY") }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="tot"/>
                </template>
            </Column>
            <Column field="licenseIsPayed" data-type="boolean" sortable header="betaald" class="text-xs">
                <template #body="{ data }">
                    <div class="text-center">
                        <i class="pi"
                           :class="{ 'pi-check-circle text-green-500': data.licenseIsPayed, 'pi-times-circle text-red-400': !data.licenseIsPayed }"></i>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <TriStateCheckbox v-model="filterModel.value" @change="filterCallback()"/>
                </template>
            </Column>
            <Column field="licenseAction" header="actie" class="text-xs"></Column>

        </DataTable>
    </div>

    <!-- ----------------------------------------------------------------------------------------------------------- -->
    <!-- dialogs                                                                                                     -->
    <!-- ----------------------------------------------------------------------------------------------------------- -->

    <Dialog v-model:visible="showDialogDetail"
            position="top"
            v-if="memberStore.memberDetail"
            :header="'Wijzig profiel voor '+memberStore.memberDetail.firstname+' '+memberStore.memberDetail.lastname"
            :modal="true">
        <dialog-change-details v-on:saved="hideDetailDialog"/>
    </Dialog>

    <Dialog v-model:visible="showDialogFullDetail"
            position="top"
            v-if="memberStore.memberDetail"
            :header="memberStore.memberDetail.firstname+' '+memberStore.memberDetail.lastname"
            :modal="true">
        <div style="width: 1350px;">
            <Splitter>
                <SplitterPanel :size="50">
                    <member-detail :type="'dialog'" estate-height="600"/>
                </SplitterPanel>
                <SplitterPanel :size="50">
                    <member-images/>
                </SplitterPanel>
            </Splitter>
        </div>
    </Dialog>

</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import {useMemberOverviewStore} from "@/store/memberOverview";
import moment from "moment/moment";
import {FilterMatchMode} from "primevue/api";
import EditButton from "@/components/common/editButton.vue";
import SmallEditButton from "@/components/common/smallEditButton.vue";
import DialogChangeDetails from "@/components/member/dialogChangeDetails.vue";
import {useMemberStore} from "@/store/member";
import MemberImages from "@/components/member/memberImages.vue";
import MemberDetail from "@/components/member/memberDetail.vue";

const memberOverviewStore = useMemberOverviewStore();
const memberStore = useMemberStore();

const showDialogFullDetail = ref<boolean>(false);
const showDialogDetail = ref<boolean>(false);

// -- datatable functions

const filters = ref({
    firstname: {value: null, matchMode: FilterMatchMode.CONTAINS},
    lastname: {value: null, matchMode: FilterMatchMode.CONTAINS},
    dateOfBirth: {value: null, matchMode: FilterMatchMode.CONTAINS},
    grade: {value: null, matchMode: FilterMatchMode.CONTAINS},                  // todo in...
    'location.name': {value: null, matchMode: FilterMatchMode.CONTAINS},        // todo in...
    memberSubscriptionStart: {value: null, matchMode: FilterMatchMode.CONTAINS},
    memberSubscriptionEnd: {value: null, matchMode: FilterMatchMode.CONTAINS},
    'federation.code': {value: null, matchMode: FilterMatchMode.CONTAINS},      // todo in...
    licenseStart: {value: null, matchMode: FilterMatchMode.CONTAINS},
    licenseEnd: {value: null, matchMode: FilterMatchMode.CONTAINS},
    memberSubscriptionIsPayed: {value: null, matchMode: FilterMatchMode.EQUALS},
    licenseIsPayed: {value: null, matchMode: FilterMatchMode.EQUALS}
});

onMounted((): void => {
    loadActiveMembers();
});

function loadActiveMembers(): void {
    void memberOverviewStore.loadActiveMembers();
}

// -- detail function

async function showDetailDialogFn(id: number): void {
    await memberStore.loadMemberDetail(id);
    showDialogDetail.value = true;
}

function hideDetailDialog(): void {
    loadActiveMembers();
    showDialogDetail.value = false;
}

// -- full detail function

async function showDetailDialogFullFn(id: number): void {
    await memberStore.loadMemberDetail(id);
    showDialogFullDetail.value = true;
}

</script>

<style>

.p-datatable-wrapper {
    border-top: 2px solid gray !important;
}

.p-paginator-bottom {
    border-top: 2px solid gray !important;
    border-bottom: 2px solid gray !important;
}

.p-column-filter-menu-button-active {
    background-color: gray !important;
    color: white !important;
}

</style>
