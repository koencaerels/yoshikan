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
    <div v-if="memberStore.memberDetail">
        <div class="flex flex-row">
            <div class="basis-1/2">
                <div class="font-bold">Lidgeld</div>
                <!-- status lidgeld -->
                <div class="block" :class="memberStatusColor(memberStore.memberDetail)">
                    <div class="mt-2 mb-2 block px-2">
                        <div class="float-left">
                            {{ moment(memberStore.memberDetail.memberSubscriptionStart).format("MM / YYYY") }}
                            >
                            {{ moment(memberStore.memberDetail.memberSubscriptionEnd).format("MM / YYYY") }}
                        </div>
                        <div class="float-left ml-4">
                            <i class="pi"
                               :class="{
                            'pi-check-circle text-green-500': memberStore.memberDetail.memberSubscriptionIsPayed,
                            'pi-times-circle text-red-400': !memberStore.memberDetail.memberSubscriptionIsPayed
                            }">
                            </i>
                        </div>
                    </div>
                    <div class="clear-left"/>
                </div>
                <div class="block">
                    <div class="pt-2 text-xs text-gray-500"
                         v-if="memberStore.memberDetail?.memberSubscriptionIsHalfYear">
                        Halfjaarlijks
                    </div>
                    <div v-else class="pt-2 text-xs text-gray-500">
                        Jaarlijks
                    </div>
                </div>
                <div v-if="showMemberSubscriptionExtendButton(memberStore.memberDetail)" class="text-right">
                    <Button @click="showExtensionFormFn()"
                            label="Verleng lidgeld"
                            class="p-button-sm p-button-secondary"
                            icon="pi pi-send"/>
                </div>
            </div>
            <div class="basis-1/2 ml-4">
                <div class="font-bold">Vergunning</div>
                <!-- status vergunning -->
                <div class="block" :class="licenseStatusColor(memberStore.memberDetail)">
                    <div class="mt-2 mb-2 block px-2">
                        <div class="float-left">
                            {{ moment(memberStore.memberDetail.licenseStart).format("MM / YYYY") }}
                            >
                            {{ moment(memberStore.memberDetail.licenseEnd).format("MM / YYYY") }}
                        </div>
                        <div class="float-left ml-4">
                            <i class="pi"
                               :class="{
                            'pi-check-circle text-green-500': memberStore.memberDetail.licenseIsPayed,
                            'pi-times-circle text-red-400': !memberStore.memberDetail.licenseIsPayed
                            }">
                            </i>
                        </div>
                    </div>
                    <div class="clear-left"/>
                </div>
                <div class="block clear-left">
                    <div class="pt-2 text-sm uppercase">
                        {{ memberStore.memberDetail.federation.name }}
                    </div>
                </div>
                <div v-if="showMemberSubscriptionExtendButton(memberStore.memberDetail)" class="text-right">
                    <Button @click="showExtensionFormFn()"
                            label="Verleng vergunning"
                            class="p-button-sm p-button-secondary"
                            icon="pi pi-send"/>
                </div>
            </div>
        </div>
        <div class="mt-2 mb-2">
            <hr>
        </div>
        <div class="flex flex-row">
            <div class="basis-1/2 p-2">
                <div class="rounded-lg bg-slate-200 p-2">
                    <div class="font-bold">
                        <span class="uppercase">{{ memberStore.memberDetail.lastname }}</span>
                        {{ memberStore.memberDetail.firstname }}
                    </div>
                    <div class="mt-4">
                        ° {{ moment(memberStore.memberDetail.dateOfBirth).format("DD/MM/YYYY") }}
                        - {{ memberStore.memberDetail.gender }}
                    </div>
                    <div class="mt-4 text-xs">
                        {{ memberStore.memberDetail.email }}
                    </div>
                    <div class="mt-4">
                        <div>
                            {{ memberStore.memberDetail.addressStreet }}
                            {{ memberStore.memberDetail.addressNumber }}
                            <span v-if="memberStore.memberDetail.addressBox != ''">
                            bus {{ memberStore.memberDetail.addressBox }}
                        </span>
                        </div>
                        <div>
                            {{ memberStore.memberDetail.addressZip }}
                            {{ memberStore.memberDetail.addressCity }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="basis-1/2 text-sm p-2">
                <div class="rounded-lg bg-orange-100 p-2">
                    <div>Contactpersoon (ouders):</div>
                    <div class="font-bold mt-4">
                        <span class="uppercase">{{ memberStore.memberDetail.contactLastname }}</span>
                        {{ memberStore.memberDetail.contactFirstname }}
                    </div>
                    <div class="mt-4 text-xs">
                        {{ memberStore.memberDetail.contactEmail }}
                    </div>
                    <div class="mt-4 text-xs">
                        {{ memberStore.memberDetail.contactPhone }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------------------------------------------------------------- -->
    <!-- dialogs                                                                                                     -->
    <!-- ----------------------------------------------------------------------------------------------------------- -->

    <Dialog v-model:visible="showExtensionForm"
            v-if="memberStore.memberDetail"
            position="top"
            :header="'Verleng lidmaatschap/vergunning voor '+memberStore.memberDetail.lastname.toUpperCase()+' '+memberStore.memberDetail.firstname"
            :modal="true">
        <extension-form :member="memberStore.memberDetail" v-on:submitted="hideExtensionFormFn"/>
    </Dialog>

</template>

<script setup lang="ts">
import moment from "moment/moment";
import GroupRenderer from "@/components/member/groupRenderer.vue";
import {useMemberStore} from "@/store/member";
import {memberStatusColor, showMemberSubscriptionExtendButton} from "@/functions/memberStatus";
import {licenseStatusColor} from "@/functions/licenseStatus";
import ExtensionForm from "@/components/member/subscription/extensionForm.vue";
import {ref} from "vue";
import {useMemberOverviewStore} from "@/store/memberOverview";

const memberStore = useMemberStore();
const memberOverviewStore = useMemberOverviewStore();
const showExtensionForm = ref<boolean>(false);

function showExtensionFormFn() {
    showExtensionForm.value = true;
}

function hideExtensionFormFn() {
    void memberOverviewStore.loadActiveMembers();
    void memberStore.reloadMemberDetail();
    memberStore.increaseMemberCounter();
    showExtensionForm.value = false;
}

</script>
