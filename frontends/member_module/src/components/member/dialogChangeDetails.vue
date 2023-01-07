<template>
    <div id="dialogChangeDetails" style="width:600px;" class="text-sm">

        <div class="flex flex-row mt-2">
            <div class="basis-1/2">
                <div class="mb-1"><label>Voornaam *</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="command.firstname"/>
                    <i v-if="!change$.firstname.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="change$.firstname.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/2 ml-4">
                <div class="mb-1"><label>Naam *</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="command.lastname"/>
                    <i v-if="!change$.lastname.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="change$.lastname.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
        </div>

        <div class="flex flex-row mt-2">
            <div class="basis-1/4 text-right">
                Geboortedatum *
            </div>
            <div class="basis-1/4 ml-4">
                <div class="mb-1"><label>DD</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="command.dateOfBirthDD"/>
                    <i v-if="!change$.dateOfBirthDD.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="change$.dateOfBirthDD.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/4 ml-4">
                <div class="mb-1"><label> / MM</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="command.dateOfBirthMM"/>
                    <i v-if="!change$.dateOfBirthMM.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="change$.dateOfBirthMM.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/4 ml-4">
                <div class="mb-1"><label> / YYYY</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="command.dateOfBirthYYYY"/>
                    <i v-if="!change$.dateOfBirthYYYY.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="change$.dateOfBirthYYYY.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
        </div>

        <div class="flex flex-row mt-4">
            <div class="basis-1/4 text-right">
                Geslacht *
            </div>
            <div class="basis-1/2 ml-4">
                <span>
                    <RadioButton name="gender" value="M" v-model="command.gender" input-id="M"/>
                    <label for="M"> M </label>
                </span>
                <span class="ml-2">
                    <RadioButton name="gender" value="V" v-model="command.gender" input-id="V"/>
                    <label for="V"> V </label>
                </span>
                <span class="ml-2">
                    <RadioButton name="gender" value="X" v-model="command.gender" input-id="X"/>
                    <label for="X"> X </label>
                </span>
            </div>
        </div>
        <hr class="mt-4">
        <div class="flex flex-row mt-4">
            <div class="basis-1/4 text-right">
                Locatie *
            </div>
            <div class="basis-1/2 ml-4">
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
        <hr class="mt-4">
        <div class="flex flex-row mt-4">
            <div class="basis-1/4 text-right">
                Actief?
            </div>
            <div class="basis-1/2 ml-4">
                <InputSwitch true-value="actief" false-value="niet actief" v-model="command.status"/>
            </div>
        </div>

        <hr class="mt-4">
        <div class="flex flex-row mt-4">
            <div class="basis-1/2">&nbsp;</div>
            <div class="basis-1/2">
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
    locationId: memberStore.memberDetail?.location.id ?? 0
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

const rules = {
    firstname: {required},
    lastname: {required},
    dateOfBirthDD: {required, numeric, maxValueValue: maxValue(31), minValueValue: minValue(1), dateValidator},
    dateOfBirthMM: {required, numeric, maxValueValue: maxValue(12), minValueValue: minValue(1), dateValidator},
    dateOfBirthYYYY: {required, numeric, minValueValue: minValue(1900), maxValueValue: maxValue(2200), dateValidator},
    locationId: {minValueValue: minValue(1)},
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
