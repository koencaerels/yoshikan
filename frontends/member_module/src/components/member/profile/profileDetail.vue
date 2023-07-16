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
                <div class="bg-slate-200 p-1 font-bold">Lidgeld</div>
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
                <div class="bg-slate-200 p-1 font-bold">Vergunning</div>
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
            <div class="basis-1/2">
                <div>
                    <span class="uppercase">{{ memberStore.memberDetail.lastname }}</span>
                    {{ memberStore.memberDetail.firstname }}
                </div>
                <div class="text-xs mt-1">
                    &mdash; {{ memberStore.memberDetail.nationalRegisterNumber }}
                </div>
                <div class="mt-2">
                    ° {{ moment(memberStore.memberDetail.dateOfBirth).format("DD/MM/YYYY") }}
                    - {{ memberStore.memberDetail.gender }}
                </div>
                <div class="mt-4">
                    <div :style="'background-color: #'+memberStore.memberDetail.grade.color"
                         class="rounded-full text-white px-2 font-bold text-center w-32 text-sm">
                        {{ memberStore.memberDetail.grade.name }}
                    </div>
                </div>
                <div class="mt-1">
                    <div class="px-2 bg-sky-400 rounded-full text-white text-xs w-32 text-center">
                        {{ memberStore.memberDetail.location.name }}
                    </div>
                </div>
                <div class="mt-1">
                    <group-renderer :member="memberStore.memberDetail"/>
                </div>
            </div>
            <div class="basis-1/2 text-sm">
                <div class="mb-4">
                    <div class="text-xs text-gray-300 w-10 float-left">email</div>
                    {{ memberStore.memberDetail.email }}
                </div>
                <hr>
                <div class="mt-4 mb-4">
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
                <hr>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------------------------------------------------------------- -->
    <!-- dialogs                                                                                                     -->
    <!-- ----------------------------------------------------------------------------------------------------------- -->

    <Dialog v-model:visible="showExtensionForm"
            v-if="memberStore.memberDetail"
            position="top"
            :header="'Verleng lidmaatschap voor '+memberStore.memberDetail.lastname.toUpperCase()+' '+memberStore.memberDetail.firstname"
            :modal="true">
        <extension-form :member="memberStore.memberDetail"/>
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

const memberStore = useMemberStore();
const showExtensionForm = ref<boolean>(false);

function showExtensionFormFn () {
    showExtensionForm.value = true;
}

</script>
