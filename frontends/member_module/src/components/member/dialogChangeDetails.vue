<template>
    <div id="dialogChangeDetails" style="width:900px;" class="text-sm">
        <!-- personal details -->
        <div class="bg-slate-600 rounded-lg px-4 py-2 text-white">
            <div class="flex flex-row">
                <div class="basis-1/2">
                    <div class="mb-1 font-bold">Naam *</div>
                    <span class="p-input-icon-right w-full">
                        <InputText class="w-full p-inputtext-sm" v-model="command.lastname"/>
                        <i v-if="!change$.lastname.$invalid" class="pi pi-check text-green-600"/>
                        <i v-if="change$.lastname.$invalid" class="pi pi-times text-red-600"/>
                    </span>
                </div>
                <div class="basis-1/2 ml-4">
                    <div class="mb-1 font-bold">Voornaam *</div>
                    <span class="p-input-icon-right w-full">
                        <InputText class="w-full p-inputtext-sm" v-model="command.firstname"/>
                        <i v-if="!change$.firstname.$invalid" class="pi pi-check text-green-600"/>
                        <i v-if="change$.firstname.$invalid" class="pi pi-times text-red-600"/>
                    </span>
                </div>
            </div>
            <!-- -- rijksregisternummer ---------------------------------------------------------------------------- -->
            <div class="flex flex-row mt-6">
                <div class="basis-1/5">
                    <!--  status -->
                    <div class="flex">
                        <div class="mt-1.5 ml-2">
                            Actief?
                        </div>
                        <div class="ml-4 mt-0.5">
                            <InputSwitch true-value="actief" false-value="niet actief" v-model="command.status"/>
                        </div>
                    </div>
                </div>
                <div class="basis-1/5 text-right text-xs font-bold">
                    Rijksregisternummer *
                </div>
                <div class="basis-2/5 ml-5">
                    <span class="p-input-icon-right w-full">
                        <InputText class="w-full p-inputtext-sm"
                                   maxlength="15"
                                   v-maska
                                   data-maska="#0.#0.#0-#00.#0"
                                   data-maska-tokens="0:[0-9]:req"
                                   v-model="command.nationalRegisterNumber"/>
                        <i v-if="!change$.nationalRegisterNumber.$invalid" class="pi pi-check text-green-600"/>
                        <i v-if="change$.nationalRegisterNumber.$invalid" class="pi pi-times text-red-600"/>
                    </span>
                </div>
                <div class="basis-1/5 ml-2 mt-2">
                <span>
                    <RadioButton name="gender" value="M" v-model="command.gender" input-id="M"/>
                    <label for="M" class="text-xs"> M </label>
                </span>
                    <span class="ml-2">
                    <RadioButton name="gender" value="V" v-model="command.gender" input-id="V"/>
                    <label for="V" class="text-xs"> V </label>
                </span>
                    <span class="ml-2">
                    <RadioButton name="gender" value="X" v-model="command.gender" input-id="X"/>
                    <label for="X" class="text-xs"> X </label>
                </span>
                </div>
            </div>
            <div class="flex flex-row mt-2 mb-2">
                <div class="basis-1/5">&nbsp;</div>
                <div class="basis-1/5 text-right text-xs mr-4 font-bold">
                    Geboortedatum *
                </div>
                <div class="basis-1/5 ml-5">
                <span class="p-input-icon-right w-3/4">
                    <InputText class="w-full p-inputtext-sm" v-model="command.dateOfBirthDD"/>
                    <i v-if="!change$.dateOfBirthDD.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="change$.dateOfBirthDD.$invalid" class="pi pi-times text-red-600"/>
                </span>
                    /
                </div>
                <div class="basis-1/5 ml-4">
                <span class="p-input-icon-right w-3/4">
                    <InputText class="w-full p-inputtext-sm" v-model="command.dateOfBirthMM"/>
                    <i v-if="!change$.dateOfBirthMM.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="change$.dateOfBirthMM.$invalid" class="pi pi-times text-red-600"/>
                </span>
                    /
                </div>
                <div class="basis-1/5 ml-4">
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="command.dateOfBirthYYYY"/>
                    <i v-if="!change$.dateOfBirthYYYY.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="change$.dateOfBirthYYYY.$invalid" class="pi pi-times text-red-600"/>
                </span>
                </div>
            </div>
        </div>
        <div class="flex flex-row mt-4">
            <div class="basis-2/6">
                <div class="flex flex-row mt-8">
                    <div class="basis-1/4 text-right">
                        Locatie *
                    </div>
                    <div class="basis-3/4 ml-4">
                        <div v-if="appStore.configuration">
                            <div v-for="location in appStore.configuration.locations" class="mr-4 mt-1">
                                <RadioButton name="location" :value="location.id"
                                             v-model="command.locationId"
                                             :input-id="location.name"/>
                                <label :for="location.name" class="ml-2"> {{ location.name }} </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="basis-4/6">
                <div class="mt-2">
                    <div class="w-full">
                        <div class="mb-1"><label class="text-xs">Email *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.email"/>
                            <i v-if="!change$.email.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="change$.email.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-3/5">
                        <div class="mb-1"><label class="text-xs">Straat *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.addressStreet"/>
                            <i v-if="!change$.addressStreet.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="change$.addressStreet.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                    <div class="basis-1/5 ml-2">
                        <div class="mb-1"><label class="text-xs">Nummer *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.addressNumber"/>
                            <i v-if="!change$.addressNumber.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="change$.addressNumber.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                    <div class="basis-1/5 ml-2">
                        <div class="mb-1"><label class="text-xs">Bus</label></div>
                        <InputText class="w-full p-inputtext-sm" v-model="command.addressBox"/>
                    </div>
                </div>
                <div class="flex flex-row mt-1">
                    <div class="basis-1/4">
                        <div class="mb-1"><label class="text-xs">Postcode *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.addressZip"/>
                            <i v-if="!change$.addressZip.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="change$.addressZip.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                    <div class="basis-3/4 ml-2">
                        <div class="mb-1"><label class="text-xs">Gemeente *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.addressCity"/>
                            <i v-if="!change$.addressCity.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="change$.addressCity.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                </div>

                <!-- contact details ------------------------------------------------------------------------------  -->
                <hr class="mt-2">
                <div class="flex flex-row mt-1">
                    <div class="basis-1/2">
                        <div class="mb-1"><label class="text-xs">Contact Naam *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.contactLastname"/>
                            <i v-if="!change$.contactLastname.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="change$.contactLastname.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                    <div class="basis-1/2 ml-2">
                        <div class="mb-1"><label class="text-xs">Voornaam *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.contactFirstname"/>
                            <i v-if="!change$.contactFirstname.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="change$.contactFirstname.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                </div>
                <div class="flex flex-row mt-1">
                    <div class="basis-1/2">
                        <div class="mb-1"><label class="text-xs">Contact email *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.contactEmail"/>
                            <i v-if="!change$.contactEmail.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="change$.contactEmail.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                    <div class="basis-1/2 ml-2">
                        <div class="mb-1"><label class="text-xs">Telefoon</label></div>
                        <InputText class="w-full p-inputtext-sm" v-model="command.contactPhone"/>
                    </div>
                </div>

            </div>
        </div>
        <div class="flex flex-row mt-4">
            <div class="w-full">
                <Button v-if="!isSaving"
                        label="Bewaar profiel"
                        @click="saveDetails"
                        icon="pi pi-save"
                        class="p-button-success p-button-sm w-full"/>
                <Button v-else disabled
                        label="Bewaar profiel"
                        icon="pi pi-spinner pi-spin"
                        class="p-button-success p-button-sm w-full"/>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import moment from "moment";
import {useAppStore} from "@/store/app";
import {useMemberStore} from "@/store/member";
import {ref} from "vue";
import {useToast} from "primevue/usetoast";
import type {ChangeMemberDetailsCommand} from "@/api/command/changeMemberDetails";
import {maxValue, minValue, numeric, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {changeMemberDetails} from "@/api/command/changeMemberDetails";
import {vMaska} from "maska";

const appStore = useAppStore();
const memberStore = useMemberStore();
const isSaving = ref<boolean>(false);
const emit = defineEmits(["saved"]);
const toaster = useToast();

const command = ref<ChangeMemberDetailsCommand>({
    id: memberStore.memberId,
    status: memberStore.memberDetail?.status ?? 'actief',
    firstname: memberStore.memberDetail?.firstname ?? '',
    lastname: memberStore.memberDetail?.lastname ?? '',
    dateOfBirth: memberStore.memberDetail?.dateOfBirth ?? new Date(),
    dateOfBirthDD: moment(memberStore.memberDetail?.dateOfBirth ?? new Date()).format("DD"),
    dateOfBirthMM: moment(memberStore.memberDetail?.dateOfBirth ?? new Date()).format("MM"),
    dateOfBirthYYYY: moment(memberStore.memberDetail?.dateOfBirth ?? new Date()).format("YYYY"),
    gender: memberStore.memberDetail?.gender ?? 'M',
    locationId: memberStore.memberDetail?.location.id ?? 0,
    nationalRegisterNumber: memberStore.memberDetail?.nationalRegisterNumber ?? '',
    addressStreet: memberStore.memberDetail?.addressStreet ?? '',
    addressNumber: memberStore.memberDetail?.addressNumber ?? '',
    addressBox: memberStore.memberDetail?.addressBox ?? '',
    addressZip: memberStore.memberDetail?.addressZip ?? '',
    addressCity: memberStore.memberDetail?.addressCity ?? '',
    email: memberStore.memberDetail?.email ?? '',
    contactFirstname: memberStore.memberDetail?.contactFirstname ?? '',
    contactLastname: memberStore.memberDetail?.contactLastname ?? '',
    contactEmail: memberStore.memberDetail?.contactEmail ?? '',
    contactPhone: memberStore.memberDetail?.contactPhone ?? '',
});

const dateValidator = function (value: string) {
    if (command.value.dateOfBirthDD.length !== 0
        && command.value.dateOfBirthMM.length !== 0
        && command.value.dateOfBirthYYYY.length !== 0
    ) {
        try {
            let dateOfBirth = new Date(
                parseInt(command.value.dateOfBirthYYYY),
                parseInt(command.value.dateOfBirthMM) - 1,
                parseInt(command.value.dateOfBirthDD),
                8,
                0,
                0,
                0
            );
            command.value.dateOfBirth = dateOfBirth;
        } catch (error) {
            return false;
        }
    }
    return true;
};

const nationalRegisterNumberValidator = function (value: string) {
    return (command.value.nationalRegisterNumber.length === 15);
}

const rules = {
    firstname: {required},
    lastname: {required},
    dateOfBirthDD: {required, numeric, maxValueValue: maxValue(31), minValueValue: minValue(1), dateValidator},
    dateOfBirthMM: {required, numeric, maxValueValue: maxValue(12), minValueValue: minValue(1), dateValidator},
    dateOfBirthYYYY: {required, numeric, minValueValue: minValue(1900), maxValueValue: maxValue(2200), dateValidator},
    locationId: {minValueValue: minValue(1)},
    nationalRegisterNumber: {nationalRegisterNumberValidator},
    email: {required},
    addressStreet: {required},
    addressNumber: {required},
    addressZip: {required},
    addressCity: {required},
    contactFirstname: {required},
    contactLastname: {required},
    contactEmail: {required},
};

const change$ = useVuelidate(rules, command);

async function saveDetails() {
    change$.value.$touch();
    if (!change$.value.$invalid) {
        isSaving.value = true;
        let result = await changeMemberDetails(command.value);
        await memberStore.reloadMemberDetail();
        memberStore.increaseMemberCounter();
        toaster.add({
            severity: "success",
            summary: "Profiel gewijzigd.",
            detail: "",
            life: appStore.toastLifeTime,
        });
        isSaving.value = false;
        emit('saved');
    }
}

</script>
