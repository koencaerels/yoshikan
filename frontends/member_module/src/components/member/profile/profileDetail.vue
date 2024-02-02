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
                    <div class="flex gap-4">
                        <div class="pt-2 text-xs text-gray-500 pl-4"
                             v-if="memberStore.memberDetail?.memberSubscriptionIsHalfYear">
                            Halfjaarlijks
                        </div>
                        <div v-else class="pt-2 text-xs text-gray-500 pl-4">
                            Jaarlijks
                        </div>
                        <div class="flex-grow">&nbsp;</div>
                        <div class="pt-2 text-xs text-gray-500 pr-4">
                            <div v-if="memberStore.memberDetail.numberOfTraining == 1">
                                1 training per week
                            </div>
                            <div v-if="memberStore.memberDetail.numberOfTraining == 2">
                                2 trainingen per week
                            </div>
                            <div v-if="memberStore.memberDetail.numberOfTraining > 2">
                                3-5 trainingen per week
                            </div>
                        </div>
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
                <div v-else class="text-right">
                    <Button @click="switchLicense()"
                            label="Switch vergunning"
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

    <Dialog v-model:visible="showSwitchLicenseForm"
            v-if="memberStore.memberDetail"
            position="top"
            :header="'Wijzig vergunning voor '+memberStore.memberDetail.lastname.toUpperCase()+' '+memberStore.memberDetail.firstname"
            :modal="true">
        <div style="width:650px">
            <div class="flex gap-4 p-4">
                <div>naar</div>
                <div>
                    <div v-if="appStore.configuration">
                        <span v-for="federation in appStore.configuration.federations" class="mr-4">
                            <RadioButton name="federation" :value="federation.id"
                                         v-model="switchLicenseCommand.federationId"
                                         :input-id="federation.name"/>
                            <label :for="federation.name" class="ml-2"> {{ federation.name.toUpperCase() }} </label>
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex gap-4 mt-2 p-2 bg-green-200">
                <div class="mt-1.5">
                    <input-switch v-model="switchLicenseCommand.sendMail" id="send-mail"/>
                </div>
                <div class="mt-0.5">
                    <label for="send-mail">E-mail verzenden?</label>
                </div>
                <div class="flex-grow">
                    <Button @click="switchLicenseAction()"
                            label="Switch vergunning"
                            :loading="isSwitching"
                            class="p-button-sm p-button-success w-full"
                            icon="pi pi-send"/>
                </div>
            </div>
        </div>
    </Dialog>

</template>

<script setup lang="ts">
import moment from "moment/moment";
import {useMemberStore} from "@/store/member";
import {memberStatusColor, showMemberSubscriptionExtendButton} from "@/functions/memberStatus";
import {licenseStatusColor} from "@/functions/licenseStatus";
import ExtensionForm from "@/components/member/subscription/extensionForm.vue";
import {ref} from "vue";
import {useMemberOverviewStore} from "@/store/memberOverview";
import {useAppStore} from "@/store/app";
import {useToast} from "primevue/usetoast";
import {changeMemberLicense, type ChangeMemberLicenseCommand} from "@/api/command/changeMemberLicense";

const memberStore = useMemberStore();
const memberOverviewStore = useMemberOverviewStore();

// -- switch extension form -------------------------------------

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

// -- switch license -------------------------------------------

const appStore = useAppStore();
const toaster = useToast();
const showSwitchLicenseForm = ref<boolean>(false);
const isSwitching = ref<boolean>(false);

function switchLicense() {
    showSwitchLicenseForm.value = true;
}

const switchLicenseCommand = ref<ChangeMemberLicenseCommand>({
    memberId: memberStore.memberDetail.id,
    federationId: memberStore.memberDetail.federation.id,
    sendMail: true,
});

async function switchLicenseAction() {
    isSwitching.value = true;
    if (switchLicenseCommand.value.federationId == memberStore.memberDetail.federation.id) {
        toaster.add({
            severity: "error",
            summary: "Fout",
            detail: "Je kan niet switchen naar dezelfde federatie.",
            life: appStore.toastLifeTime,
        });
        isSwitching.value = false;
        return;
    }
    const result = await changeMemberLicense(switchLicenseCommand.value);
    toaster.add({
        severity: "success",
        summary: "Wijziging federatie gelukt, bericht is verzonden.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    await memberStore.reloadMemberDetail();
    memberStore.increaseMemberCounter();
    isSwitching.value = false;
    showSwitchLicenseForm.value = false;
}

</script>
