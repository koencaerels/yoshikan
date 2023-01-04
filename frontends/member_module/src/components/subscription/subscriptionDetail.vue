<template>
    <div id="subscriptionDetail">
        <!-- -- step 1 -- check subscription -->
        <div class="bg-gray-700 text-white p-2" v-if="memberStore.subscriptionDetail">
            Stap 1: controleer en vervolledig de inschrijving: YKS-{{memberStore.subscriptionDetail.id}}.
        </div>
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
                <div class="flex flex-row mt-2">
                    <div class="basis-1/4 text-right mr-4">
                        Gezinskorting
                    </div>
                    <div class="basis-2/12">
                        <InputSwitch v-model="command.reductionFamily"/>
                    </div>
                    <div class="basis-2/3">
                        <span class="font-bold text-base">
                            {{ subscriptionFee }} €
                        </span>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/4 text-right mr-4">
                        3 tot 5 trainingen
                    </div>
                    <div class="basis-2/12">
                        <InputSwitch v-model="command.extraTraining"/>
                    </div>
                    <div class="basis-2/3">
                        <div v-if="command.extraTraining && memberStore.subscriptionDetail" class="font-bold text-base">
                            + {{ memberStore.subscriptionDetail.settings.extraTrainingFee }} €
                        </div>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/4 text-right mr-4">
                        Nieuw lid
                    </div>
                    <div class="basis-2/12">
                        <InputSwitch v-model="command.newMember"/>
                    </div>
                    <div class="basis-2/3">
                        <div v-if="command.newMember && memberStore.subscriptionDetail" class="font-bold text-base">
                            + {{ memberStore.subscriptionDetail.settings.newMemberSubscriptionFee }} €
                            (Inschrijvingspakket)
                        </div>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/4 text-right mr-4">
                        Judopak + gordel
                    </div>
                    <div class="basis-2/12">
                        <InputSwitch v-model="command.judogiBelt" v-on:change="changeJudogi"/>
                    </div>
                    <div class="basis-1/3">
                        <Dropdown class="w-full"
                                  v-if="command.judogiBelt"
                                  :show-clear="true"
                                  v-on:change="changeJudogiSize"
                                  v-model="command.judogiId"
                                  option-label="name" option-value="id"
                                  :options="appStore.configuration.judogi"/>
                    </div>
                    <div class="basis-1/3">
                        <span class="p-input-icon-right w-full pl-2" v-if="command.judogiBelt">
                            <InputText class="w-full p-inputtext-sm" v-model="command.judogiPrice"/>
                            <i v-if="!change$.judogiPrice.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="change$.judogiPrice.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                </div>
                <div class="flex flex-row mt-4 pb-4">
                    <div class="basis-1/4 text-right">
                        Opmerkingen
                    </div>
                    <div class="basis-3/4 ml-4">
                        <Textarea v-model="command.remarks" :autoResize="true" rows="2" cols="30" class="w-full"/>
                    </div>
                </div>
            </div>
        </detail-wrapper>
        <div class="flex flex-row pt-2 pb-2 bg-gray-300">
            <div class="basis-1/2 text-xl ml-4">
                <div class="flex">
                    <div class="mt-0.5">Totaal</div>
                    <div class="mr-2 ml-2 text-sm">
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.total"/>
                            <i v-if="!change$.total.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="change$.total.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                    <div class="mt-0.5 mr-4">€</div>
                    <div class="w-1-2 mr-4 text-sm">
                        <Button icon="pi pi-calculator" @click="calculate" class="p-button-sm"/>
                    </div>
                </div>
            </div>
            <div class="basis-1/2 mr-4">
                <Button v-if="!isSaving"
                        @click="changeSubscriptionHandler"
                        label="Bewaar inschrijving"
                        icon="pi pi-save"
                        class="w-full p-button-success p-button-sm"/>
                <Button v-else label="Bewaar inschrijving"
                        disabled
                        icon="pi pi-spinner pi-spin"
                        class="w-full p-button-success p-button-sm"/>
            </div>
        </div>

        <!-- -- step 2 -- change the status -->
        <div class="bg-gray-700 text-white p-2" v-if="memberStore.subscriptionDetail">
            Stap 2: wijzig de status van de inschrijving: YKS-{{memberStore.subscriptionDetail.id}}.
        </div>
        <SubscriptionDetailStatus/>

        <!-- -- step 3 -- connect to member -->
        <div v-if="memberStore.subscriptionDetail">
            <div v-if="memberStore.subscriptionDetail.member">
                <div class="bg-gray-700 text-white p-2">Stap 3: gekoppeld lid voor deze inschrijving.</div>
            </div>
            <div v-else>
                <div class="bg-gray-700 text-white p-2">Stap 3: koppel bestaand lid of maak nieuw lid aan.</div>
            </div>
        </div>
        <SubscriptionDetailMember/>

    </div>
</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import {computed, ref} from "vue";
import type {ChangeSubscriptionCommand} from "@/api/command/changeSubscription";
import moment from "moment";
import {useAppStore} from "@/store/app";
import DetailWrapper from "@/components/wrapper/detailWrapper.vue";
import {email, maxValue, minValue, numeric, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {changeSubscription} from "@/api/command/changeSubscription";
import {useToast} from "primevue/usetoast";
import SubscriptionDetailStatus from "@/components/subscription/subscriptionDetailStatus.vue";
import SubscriptionDetailMember from "@/components/subscription/subscriptionDetailMember.vue";

const appStore = useAppStore();
const memberStore = useMemberStore();

const command = ref<ChangeSubscriptionCommand>({
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
    judogiPrice: memberStore.subscriptionDetail?.judogiPrice ?? '0',
    judogiId: memberStore.subscriptionDetail?.judogi?.id ?? 0,
    remarks: memberStore.subscriptionDetail?.remarks ?? '',
    total: memberStore.subscriptionDetail?.total ?? '0',
});

// -- validation ------------------------------------------

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
    judogiPrice: {required, numeric},
    total: {required, numeric},
};

const change$ = useVuelidate(rules, command);

// -- calculate this subscription  ------------------------------------

const subscriptionFee = computed((): number => {
    let fee = 0;
    if (memberStore.subscriptionDetail) {
        if (command.value.type === 'volledig jaar') {
            if (command.value.numberOfTraining === 1) {
                fee = parseFloat(memberStore.subscriptionDetail.settings.yearlyFee1Training);
            } else {
                fee = parseFloat(memberStore.subscriptionDetail.settings.yearlyFee2Training);
            }
        } else {
            if (command.value.numberOfTraining === 1) {
                fee = parseFloat(memberStore.subscriptionDetail.settings.halfYearlyFee1Training);
            } else {
                fee = parseFloat(memberStore.subscriptionDetail.settings.halfYearlyFee2Training);
            }
        }
    }
    if (command.value.reductionFamily && memberStore.subscriptionDetail) {
        let reduction = (parseFloat(memberStore.subscriptionDetail.settings.familyDiscount) * fee) / 100;
        fee = Math.ceil(fee - reduction);
    }
    return fee;
});

function calculate(): void {
    let fee = subscriptionFee.value;
    if (command.value.extraTraining && memberStore.subscriptionDetail) {
        fee = fee + parseFloat(memberStore.subscriptionDetail.settings.extraTrainingFee);
    }
    if (command.value.newMember && memberStore.subscriptionDetail) {
        fee = fee + parseFloat(memberStore.subscriptionDetail.settings.newMemberSubscriptionFee);
    }
    fee = fee + parseFloat(command.value.judogiPrice.toString());
    command.value.total = fee.toString();
}

function changeJudogi() {
    if (!command.value.judogiBelt) {
        command.value.judogiPrice = '0';
        command.value.judogiId = 0;
    }
}

function changeJudogiSize() {
    if (command.value.judogiId && appStore.configuration) {
        let judogi = appStore.configuration.judogi.find(c => c.id === command.value.judogiId);
        if (judogi) {
            command.value.judogiPrice = judogi.price;
        }
    } else {
        command.value.judogiPrice = '0';
    }
}

// -- change subscription ---------------------------------------------

const isSaving = ref<boolean>(false);
const toaster = useToast();
async function changeSubscriptionHandler() {
    change$.value.$touch();
    if (!change$.value.$invalid) {
        isSaving.value = true;
        await changeSubscription(command.value);
        toaster.add({
            severity: "success",
            summary: "Inschrijving bewaard.",
            detail: "",
            life: appStore.toastLifeTime,
        });
        await memberStore.reloadSubscriptionDetail();
        memberStore.increaseCounter();
        isSaving.value = false;
    }
}

</script>
