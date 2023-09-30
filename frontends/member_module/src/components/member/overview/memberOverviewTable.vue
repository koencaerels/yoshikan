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
    <div id="memberOverviewHeader" class="p-1 bg-gradient-to-r from-slate-600 to-slate-400 text-white">
        <div class="flex flex-row">
            <div class="basis-1/2">
                <div class="flex gap-2 mt-1 ml-1">
                    <Button label="Lid aanmaken"
                            @click="showNewMemberFormFn"
                            icon="pi pi-user-plus"
                            class="p-button-sm"/>
                </div>
            </div>
            <div class="basis-1/2 text-right">
                <div class="flex gap-2 float-right mt-0.5">
                    <div class="flex mt-1.5">
                        <div class="ml-2">
                            <InputSwitch v-model="filterMemberList" input-id="showMemberExtensions"/>
                        </div>
                        <div class="ml-4 mr-4 text-sm">
                            <label for="showMemberExtensions">Toon te verlengen leden.</label>
                        </div>
                    </div>
                    <Button @click="downloadListDuePayments"
                            label="Download overzicht te betalen"
                            icon="pi pi-download"
                            class="p-button-sm p-button-secondary"/>
                </div>
            </div>
        </div>
    </div>
    <!-- datatable -->
    <div>
        <DataTable :value="members"
                   v-model:filters="filters"
                   class="p-datatable-sm text-xs"
                   paginator :rows="20"
                   show-gridlines
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
            <!-- personalia                                                                                          -->
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
                    <div @click="showDetailDialogFullFn(data.id)" class="text-base uppercase font-bold text-sm">
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
                    <div class="text-base font-bold text-sm" @click="showDetailDialogFullFn(data.id)">
                        {{ data.firstname }}
                    </div>
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
            <Column field="grade.name" sortable header="Graad" class="text-xs">
                <template #body="{ data }">
                    <div class="text-white rounded-full text-xs px-2 text-center"
                         :style="'background-color:#'+data.grade.color">
                        {{ data.grade.name }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <Dropdown class="w-full" v-if="appStore.configuration"
                              :show-clear="true"
                              v-model="filterModel.value"
                              placeholder="selecteer een graad"
                              @input="filterCallback()"
                              option-label="name"
                              option-value="name"
                              :options="appStore.configuration.grades">
                        <template #option="slotProps">
                            <div class="text-white rounded-full text-sm px-3"
                                 :style="'background-color:#'+slotProps.option.color">
                                {{ slotProps.option.name }}
                            </div>
                        </template>
                    </Dropdown>
                </template>
            </Column>
            <Column field="location.name" sortable header="Locatie" class="text-xs">
                <template #body="slotProps">
                    <div class="text-xs w-[7rem]">
                        {{ slotProps.data.location.name }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <Dropdown class="w-full" v-if="appStore.configuration"
                              @input="filterCallback()"
                              v-model="filterModel.value"
                              :show-clear="true"
                              placeholder="selecteer een locatie"
                              option-label="name" option-value="name"
                              :options="appStore.configuration.locations"/>
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
            <!-- lidgeld                                                                                             -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <Column field="memberSubscriptionStart" style="border-left:1px solid black;" sortable header="van"
                    class="text-xs no-padding">
                <template #body="{ data }">
                    <div class="text-xs text-center" :class="memberStatusColor(data)">
                        {{ moment(data.memberSubscriptionStart).format("MM / YYYY") }} &mdash;
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value"
                               type="text" @input="filterCallback()"
                               class="p-column-filter"
                               placeholder="van"/>
                </template>
            </Column>
            <Column field="memberSubscriptionEnd" sortable header="tot" class="text-xs no-padding">
                <template #body="{ data }">
                    <div class="text-xs text-center font-bold" :class="memberStatusColor(data)">
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
            <Column field="memberSubscriptionIsPayed" data-type="boolean" sortable header="betaald"
                    class="text-xs no-padding">
                <template #body="{ data }">
                    <div class="text-xs text-center" :class="memberStatusColor(data)">
                        <i class="pi"
                           :class="{ 'pi-check-circle text-green-500': data.memberSubscriptionIsPayed, 'pi-times-circle text-red-400': !data.memberSubscriptionIsPayed }"></i>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <TriStateCheckbox v-model="filterModel.value" @change="filterCallback()"/>
                </template>
            </Column>
            <Column field="membershipAction" header="actie" class="text-xs no-padding">
                <template #body="{ data }">
                    <div class="text-xs text-center" :class="memberStatusColor(data)">
                        <span v-if="showMemberSubscriptionExtendButton(data)" @click="showExtensionFormFn(data.id)">
                            <i class="pi pi-send"></i>
                        </span>
                    </div>
                </template>
            </Column>

            <!-- --------------------------------------------------------------------------------------------------- -->
            <!-- vergunning                                                                                          -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <Column field="federation.code" sortable header="Fed." class="text-xs no-padding"
                    style="border-left:1px solid black">
                <template #body="{ data }">
                    <div class="text-xs text-center" :class="licenseStatusColor(data)">
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
            <Column field="licenseStart" sortable header="van" class="text-xs no-padding">
                <template #body="{ data }">
                    <div class="text-xs text-center" :class="licenseStatusColor(data)">
                        {{ moment(data.licenseStart).format("MM / YYYY") }} &mdash;
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="van"/>
                </template>
            </Column>
            <Column field="licenseEnd" sortable header="tot" class="text-xs no-padding">
                <template #body="{ data }">
                    <div class="text-xs text-center font-bold" :class="licenseStatusColor(data)">
                        {{ moment(data.licenseEnd).format("MM / YYYY") }}
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter"
                               placeholder="tot"/>
                </template>
            </Column>
            <Column field="licenseIsPayed" data-type="boolean" sortable header="betaald" class="text-xs no-padding">
                <template #body="{ data }">
                    <div class="text-xs text-center" :class="licenseStatusColor(data)">
                        <i class="pi"
                           :class="{ 'pi-check-circle text-green-500': data.licenseIsPayed, 'pi-times-circle text-red-400': !data.licenseIsPayed }"></i>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <TriStateCheckbox v-model="filterModel.value" @change="filterCallback()"/>
                </template>
            </Column>
            <Column field="licenseAction" header="actie" class="text-xs no-padding">
                <template #body="{ data }">
                    <div class="text-xs text-center" :class="licenseStatusColor(data)">
                        <span v-if="showLicenseExtendButton(data)" @click="showExtensionFormFn(data.id)">
                            <i class="pi pi-send"></i>
                        </span>
                    </div>
                </template>
            </Column>

        </DataTable>
    </div>

    <!-- ----------------------------------------------------------------------------------------------------------- -->
    <!-- dialogs                                                                                                     -->
    <!-- ----------------------------------------------------------------------------------------------------------- -->

    <Dialog v-model:visible="showDialogNewMember"
            position="topleft"
            :header="'Maak een nieuw lid aan...' "
            :modal="true">
        <new-member-form v-on:submitted="hideNewMemberFormFn"/>
    </Dialog>

    <Dialog v-model:visible="showDialogDetail"
            v-if="memberStore.memberDetail"
            position="top"
            :header="'Wijzig profiel voor '+memberStore.memberDetail.lastname.toUpperCase()+' '+memberStore.memberDetail.firstname"
            :modal="true">
        <dialog-change-details v-on:saved="hideDetailDialog"/>
    </Dialog>

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

    <Dialog v-model:visible="showExtensionForm"
            v-if="memberStore.memberDetail"
            position="top"
            :header="'Verleng lidmaatschap / vergunning voor...' "
            :modal="true">
        <extension-form :member="memberStore.memberDetail" v-on:submitted="hideExtensionFormFn"/>
    </Dialog>

</template>

<script setup lang="ts">
import {computed, onMounted, ref} from "vue";
import {useMemberOverviewStore} from "@/store/memberOverview";
import moment from "moment/moment";
import {FilterMatchMode} from "primevue/api";
import SmallEditButton from "@/components/common/smallEditButton.vue";
import DialogChangeDetails from "@/components/member/dialogChangeDetails.vue";
import {useMemberStore} from "@/store/member";
import MemberImages from "@/components/member/memberImages.vue";
import MemberDetail from "@/components/member/memberDetail.vue";
import ExtensionForm from "@/components/member/subscription/extensionForm.vue";
import {useAppStore} from "@/store/app";
import {memberStatusColor, showMemberSubscriptionExtendButton} from "@/functions/memberStatus";
import {licenseStatusColor, showLicenseExtendButton} from "@/functions/licenseStatus";
import type {Member} from "@/api/query/model";
import NewMemberForm from "@/components/member/subscription/newMemberForm.vue";

const memberOverviewStore = useMemberOverviewStore();
const memberStore = useMemberStore();
const appStore = useAppStore();

const showDialogFullDetail = ref<boolean>(false);
const showDialogDetail = ref<boolean>(false);
const filterMemberList = ref<boolean>(false);

const apiUrl = import.meta.env.VITE_API_URL;

// -- computed property to filter the list with members to pay

const members = computed((): Array<Member> => {
    let _result: Array<Member> = [];
    if (!filterMemberList.value === true) {
        _result = memberOverviewStore.members;
    } else {
        for (const _member of memberOverviewStore.members) {
            if (showMemberSubscriptionExtendButton(_member) || showLicenseExtendButton(_member)) {
                _result.push(_member);
            }
        }
    }
    return _result;
});

// -- datatable functions

const filters = ref({
    firstname: {value: null, matchMode: FilterMatchMode.CONTAINS},
    lastname: {value: null, matchMode: FilterMatchMode.CONTAINS},
    dateOfBirth: {value: null, matchMode: FilterMatchMode.CONTAINS},
    'grade.name': {value: null, matchMode: FilterMatchMode.CONTAINS},
    'location.name': {value: null, matchMode: FilterMatchMode.EQUALS},
    memberSubscriptionStart: {value: null, matchMode: FilterMatchMode.CONTAINS},
    memberSubscriptionEnd: {value: null, matchMode: FilterMatchMode.CONTAINS},
    'federation.code': {value: null, matchMode: FilterMatchMode.EQUALS},
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

// -- membership extension form

const showExtensionForm = ref<boolean>(false);

async function showExtensionFormFn(id: number) {
    await memberStore.loadMemberDetail(id);
    showExtensionForm.value = true;
}

function hideExtensionFormFn(): void {
    loadActiveMembers();
    showExtensionForm.value = false;
}

// new membership form

const showDialogNewMember = ref<boolean>(false);

function showNewMemberFormFn() {
    showDialogNewMember.value = true;
}

function hideNewMemberFormFn(): void {
    loadActiveMembers();
    showDialogNewMember.value = false;
}

function downloadListDuePayments() {
    let url = apiUrl + '/member/overview-due-payments';
    window.open(url, '_blank');
}

</script>

<!-- --------------------------------------------------------------------------------------------------------------- -->
<!-- styling                                                                                                         -->
<!-- --------------------------------------------------------------------------------------------------------------- -->

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

th.p-sortable-column.no-padding {
    padding: 8px !important;
}

tr.p-selectable-row .no-padding {
    padding: 0px !important;
}

tr.p-selectable-row .no-padding div {
    display: block;
    height: 30px;
    padding-top: 7px;
}

</style>
