<template>
    <div id="subscriptionDetail">
        <!-- -- step 1 -- check subscription -->
        <div class="bg-gray-700 text-white p-2">Stap 1: controleer en vervolledig de inschrijving.</div>
        <detail-wrapper :estate-height="600" class="bg-gray-100">
            <div class="px-4 text-sm" v-if="appStore.configuration">
                <div class="flex flex-row mt-2">
                    <div class="basis-1/2">
                        <div class="mb-1"><label>Contact voornaam *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.contactFirstname"/>
                            <i v-if="!change$.contactFirstname.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="change$.contactFirstname.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                    <div class="basis-1/2 ml-4">
                        <div class="mb-1"><label>Contact naam *</label></div>
                        <span class="p-input-icon-right w-full">
                        <InputText class="w-full p-inputtext-sm" v-model="command.contactLastname"/>
                        <i v-if="!change$.contactLastname.$invalid" class="pi pi-check text-green-600"/>
                        <i v-if="change$.contactLastname.$invalid" class="pi pi-times text-red-600"/>
                    </span>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/2">
                        <div class="mb-1"><label>Contact email *</label></div>
                        <span class="p-input-icon-right w-full">
                        <InputText class="w-full p-inputtext-sm" v-model="command.contactEmail"/>
                        <i v-if="!change$.contactEmail.$invalid" class="pi pi-check text-green-600"/>
                        <i v-if="change$.contactEmail.$invalid" class="pi pi-times text-red-600"/>
                    </span>
                    </div>
                    <div class="basis-1/2 ml-4">
                        <div class="mb-1"><label>Contact telefoon</label></div>
                        <span class="p-input-icon-right w-full">
                        <InputText class="w-full p-inputtext-sm" v-model="command.contactPhone"/>
                    </span>
                    </div>
                </div>
                <div class="mt-3">
                    <hr>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/2">
                        <div class="mb-1"><label><strong>Judoka voornaam *</strong></label></div>
                        <span class="p-input-icon-right w-full">
                        <InputText class="w-full p-inputtext-sm" v-model="command.firstname"/>
                        <i v-if="!change$.firstname.$invalid" class="pi pi-check text-green-600"/>
                        <i v-if="change$.firstname.$invalid" class="pi pi-times text-red-600"/>
                    </span>
                    </div>
                    <div class="basis-1/2 ml-4">
                        <div class="mb-1"><label><strong>Judoka naam *</strong></label></div>
                        <span class="p-input-icon-right w-full">
                        <InputText class="w-full p-inputtext-sm" v-model="command.lastname"/>
                        <i v-if="!change$.lastname.$invalid" class="pi pi-check text-green-600"/>
                        <i v-if="change$.lastname.$invalid" class="pi pi-times text-red-600"/>
                    </span>
                    </div>
                </div>

                <div class="flex flex-row mt-2">
                    <div class="basis-1/4 text-right">
                        <strong>Geboortedatum *</strong>
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
                        <strong>Geslacht *</strong>
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
                <div class="mt-3">
                    <hr>
                </div>
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right">
                        Locatie
                    </div>
                    <div class="basis-3/4 ml-4">
                        <div v-if="appStore.configuration">
                        <span v-for="location in appStore.configuration.locations" class="mr-4">
                            <RadioButton name="location" :value="location.id"
                                         v-model="command.locationId"
                                         :input-id="location.name"/>
                            <label :for="location.name" class="ml-2"> {{ location.name }} </label>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right">
                        Type
                    </div>
                    <div class="basis-3/4 ml-4">
                    <span>
                        <RadioButton name="type" value="volledig jaar" v-model="command.type" input-id="full"/>
                        <label for="yes"> Volledig jaar </label>
                    </span>
                        <span class="ml-2">
                        <RadioButton name="type" value="half jaar" v-model="command.type" input-id="half"/>
                        <label for="no"> Half jaar </label>
                    </span>
                    </div>
                </div>
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right">
                        Aantal trainingen
                    </div>
                    <div class="basis-3/4 ml-4">
                        <span>
                            <RadioButton name="numberOfTraining" :value="1" v-model="command.numberOfTraining"
                                         input-id="1times"/>
                            <label for="1times"> 1 keer per week </label>
                        </span>
                        <span class="ml-2">
                            <RadioButton name="numberOfTraining" :value="2" v-model="command.numberOfTraining"
                                         input-id="2times"/>
                            <label for="2times"> 2 keer per week </label>
                        </span>
                    </div>
                </div>
                <div class="mt-3">
                    <hr>
                </div>
                <!-- -- extra switches ---------------------------------- -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right">
                        3 tot 5 trainingen
                    </div>
                    <div class="basis-1/4 ml-4">
                        <InputSwitch v-model="command.extraTraining"/>
                    </div>
                </div>
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right">
                        Nieuw lid
                    </div>
                    <div class="basis-1/4 ml-4">
                        <InputSwitch v-model="command.newMember"/>
                    </div>
                </div>
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right">
                        Judopak + gordel
                    </div>
                    <div class="basis-1/4 ml-4">
                        <InputSwitch v-model="command.judogiBelt"/>
                    </div>
                </div>
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right">
                        Gezinskorting
                    </div>
                    <div class="basis-1/4 ml-4">
                        <InputSwitch v-model="command.reductionFamily"/>
                    </div>
                </div>
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right">
                        Opmerkingen
                    </div>
                    <div class="basis-3/4 ml-4">
                        <Textarea v-model="command.remarks" :autoResize="true" rows="2" cols="30" class="w-full"/>
                    </div>
                </div>
            </div>
        </detail-wrapper>
        <div class="flex flex-row pt-2 pb-2 bg-gray-100">
            <div class="basis-1/2 text-xl ml-4">
                Totaal : xxx €
            </div>
            <div class="basis-1/2 mr-4">
                <Button v-if="!isSaving"
                        label="Wijzig details"
                        icon="pi pi-save"
                        class="w-full p-button-success p-button-sm"/>
                <Button v-else label="Wijzig details"
                        disabled
                        icon="pi pi-spinner pi-spin"
                        class="w-full p-button-success p-button-sm"/>
            </div>
        </div>

        <!-- -- step 2 -- change the status -->
        <div class="bg-gray-700 text-white p-2">Stap 2: wijzig de status van de inschrijving.</div>
        <div class="px-4 py-2" v-if="memberStore.subscriptionDetail">
            <div class="flex flex-row">
                <div class="basis-1/2">
                    <div class="px-2 bg-sky-400 rounded-full text-white text-xs w-32 text-center">
                        {{ memberStore.subscriptionDetail.location.name }}
                    </div>
                    <subscription-tag :subscription="memberStore.subscriptionDetail" class="mt-2"/>
                    <div class="mt-2">
                        <strong>{{ memberStore.subscriptionDetail.firstname }}
                            {{ memberStore.subscriptionDetail.lastname }}</strong>
                        <span class="text-xs"> (°
                            {{ moment(memberStore.subscriptionDetail.dateOfBirth).format("DD/MM/YYYY") }}
                        - {{ memberStore.subscriptionDetail.gender }}
                        )</span>
                    </div>
                </div>
                <div class="basis-1/2">
                    <div class="flex">
                        <div class="w-full">
                            <Dropdown class="w-full" v-model="newStatus" :options="status"/>
                        </div>
                        <div>
                            <Button icon="pi pi-save" class="p-button-success"/>
                        </div>
                    </div>
                    <div class="mt-2 pb-2">
                        <div class="cursor-pointer">
                            <i class="pi pi-envelope"></i> Verzend email met betalings instructies.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- -- step 3 -- connect to member -->
        <div class="bg-gray-700 text-white p-2">Stap 3: koppel bestaand lid of maak nieuw lid aan.</div>
        <div class="px-4 py-2">
            <div>
                <Button label="Maak nieuw lid aan" class="p-button-success p-button-sm" icon="pi pi-user"/>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import SubscriptionTag from "@/components/subscription/subscriptionTag.vue";
import {ref} from "vue";
import type {changeSubscriptionCommand} from "@/api/command/changeSubscription";
import moment from "moment";
import {useAppStore} from "@/store/app";
import DetailWrapper from "@/components/wrapper/detailWrapper.vue";
import {email, maxValue, minValue, numeric, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";

const memberStore = useMemberStore();
const appStore = useAppStore();
const status = ['nieuw', 'wachtend op betaling', 'betaald', 'afgewezen'];
const newStatus = ref<string>(memberStore.subscriptionDetail?.status ?? 'nieuw');
const isSaving = ref<boolean>(false);

const command = ref<changeSubscriptionCommand>({
    id: memberStore.subscriptionDetail?.id ?? 0,
    contactFirstname: memberStore.subscriptionDetail?.contactFirstname ?? '',
    contactLastname: memberStore.subscriptionDetail?.contactLastname ?? '',
    contactEmail: memberStore.subscriptionDetail?.contactEmail ?? '',
    contactPhone: memberStore.subscriptionDetail?.contactPhone ?? '',
    firstname: memberStore.subscriptionDetail?.firstname ?? '',
    lastname: memberStore.subscriptionDetail?.lastname ?? '',
    dateOfBirthDD: moment(memberStore.subscriptionDetail?.dateOfBirth ?? 0).format("DD"),
    dateOfBirthMM: moment(memberStore.subscriptionDetail?.dateOfBirth ?? 0).format("MM"),
    dateOfBirthYYYY: moment(memberStore.subscriptionDetail?.dateOfBirth ?? 0).format("YYYY"),
    dateOfBirth: new Date(memberStore.subscriptionDetail?.dateOfBirth ?? 0),
    gender: memberStore.subscriptionDetail?.gender ?? 'M',
    newMember: memberStore.subscriptionDetail?.isNewMember ?? false,
    locationId: memberStore.subscriptionDetail?.location.id ?? 1,
    type: memberStore.subscriptionDetail?.type ?? 'volledig jaar',
    numberOfTraining: memberStore.subscriptionDetail?.numberOfTraining ?? 1,
    extraTraining: memberStore.subscriptionDetail?.isExtraTraining ?? false,
    reductionFamily: memberStore.subscriptionDetail?.isReductionFamily ?? false,
    judogiBelt: memberStore.subscriptionDetail?.isJudogiBelt ?? false,
    remarks: memberStore.subscriptionDetail?.remarks ?? '',
});

// -- validation ---------------------------------------

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
    contactFirstname: {required},
    contactLastname: {required},
    contactEmail: {required, email},
    firstname: {required},
    lastname: {required},
    dateOfBirthDD: {required, numeric, maxValueValue: maxValue(31), minValueValue: minValue(1), dateValidator},
    dateOfBirthMM: {required, numeric, maxValueValue: maxValue(12), minValueValue: minValue(1), dateValidator},
    dateOfBirthYYYY: {required, numeric, minValueValue: minValue(1900), maxValueValue: maxValue(2200), dateValidator},
    locationId: {minValueValue: minValue(1)},
};

const change$ = useVuelidate(rules, command);

</script>
