<template>
    <div id="subscriptionChange" style="width:1200px;">
        <div class="flex flex-row">
            <!-- --------------------------------------------------------------------------------------------------- -->
            <!-- column 1 -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <div class="basis-1/2">

                <div class="px-4 text-sm" v-if="appStore.configuration">

                    <!-- nieuw lid -->
                    <div class="flex bg-slate-200 p-2 rounded-lg">
                        <div>
                            <div v-if="command.newMember"><i class="pi pi-user-plus"></i></div>
                            <div v-else><i class="pi pi-refresh"></i></div>
                        </div>
                        <div class="ml-4">
                            <strong>Nieuw lid?</strong>
                        </div>
                        <div class="ml-4">
                        <span>
                            <RadioButton name="newMember" :value="true" v-model="command.newMember" input-id="yes"/>
                            <label for="yes"><strong> Ja </strong></label>
                        </span>
                            <span class="ml-2">
                            <RadioButton name="newMember" :value="false" v-model="command.newMember" input-id="no"/>
                            <label for="no"><strong> Nee </strong></label>
                        </span>
                        </div>
                    </div>

                    <div class="flex flex-row mt-1">
                        <div class="basis-1/2">
                            <div class="mb-1"><label class="text-xs">Contact voornaam *</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="command.contactFirstname"/>
                                <i v-if="!change$.contactFirstname.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="change$.contactFirstname.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                        <div class="basis-1/2 ml-4">
                            <div class="mb-1"><label class="text-xs">Contact naam *</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="command.contactLastname"/>
                                <i v-if="!change$.contactLastname.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="change$.contactLastname.$invalid" class="pi pi-times text-red-600"/>
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
                        <div class="basis-1/2 ml-4">
                            <div class="mb-1"><label class="text-xs">Contact telefoon</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="command.contactPhone"/>
                            </span>
                        </div>
                    </div>

                    <!-- -- adres ---------------------------------------------------------------------------------- -->
                    <div v-if="command.newMember">
                        <div class="flex flex-row mt-1">
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
                    </div>

                    <div v-if="!command.newMember">&nbsp;</div>

                    <!-- judoka -->
                    <div class="bg-slate-200 p-2 mt-4 rounded-lg pb-3">
                        <div class="flex flex-row">
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

                        <!-- -- rijksregisternummer ---------------------------------------------------------------- -->
                        <div class="flex flex-row mt-2" v-if="command.newMember">
                            <div class="basis-1/4 text-right mr-2 text-sm">
                                Rijksregisternummer*
                            </div>
                            <div class="basis-3/4">
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
                        </div>

                        <div class="flex flex-row mt-1">
                            <div class="basis-1/4 text-right">Geboortedatum*</div>
                            <div class="basis-1/4 ml-4">
                                <div class="mb-1"><label class="text-xs">DD</label></div>
                                <span class="p-input-icon-right w-full">
                                    <InputText class="w-full p-inputtext-sm" v-model="command.dateOfBirthDD"/>
                                    <i v-if="!change$.dateOfBirthDD.$invalid" class="pi pi-check text-green-600"/>
                                    <i v-if="change$.dateOfBirthDD.$invalid" class="pi pi-times text-red-600"/>
                                </span>
                            </div>
                            <div class="basis-1/4 ml-4">
                                <div class="mb-1"><label class="text-xs"> / MM</label></div>
                                <span class="p-input-icon-right w-full">
                                    <InputText class="w-full p-inputtext-sm" v-model="command.dateOfBirthMM"/>
                                    <i v-if="!change$.dateOfBirthMM.$invalid" class="pi pi-check text-green-600"/>
                                    <i v-if="change$.dateOfBirthMM.$invalid" class="pi pi-times text-red-600"/>
                                </span>
                            </div>
                            <div class="basis-1/4 ml-4">
                                <div class="mb-1"><label class="text-xs"> / YYYY</label></div>
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

                    </div>
                </div>
            </div>
            <!-- --------------------------------------------------------------------------------------------------- -->
            <!-- column 2 -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <div class="basis-1/2 ml-4 text-sm">

                <div class="flex flex-row mt-2">
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
                <div class="flex flex-row mt-6">
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
                <div class="flex flex-row mt-6">
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
                <div class="mt-8 mb-6">
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
                    <div class="basis-1/3" v-if="appStore.configuration">
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

                <!-- action buttons -->
                <div class="flex flex-row p-4 bg-slate-300 rounded-lg">
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

            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {useMemberStore} from "@/store/member";
import {computed, ref} from "vue";
import {changeSubscription} from "@/api/command/changeSubscription";
import type {ChangeSubscriptionCommand} from "@/api/command/changeSubscription";
import moment from "moment/moment";
import {email, maxValue, minValue, numeric, required, requiredIf} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {useToast} from "primevue/usetoast";
import {vMaska} from "maska";

const appStore = useAppStore();
const memberStore = useMemberStore();
const emit = defineEmits(["saved"]);

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
    nationalRegisterNumber:memberStore.subscriptionDetail?.nationalRegisterNumber ?? '',
    addressStreet:memberStore.subscriptionDetail?.addressStreet ?? '',
    addressNumber:memberStore.subscriptionDetail?.addressNumber ?? '',
    addressBox:memberStore.subscriptionDetail?.addressBox ?? '',
    addressZip:memberStore.subscriptionDetail?.addressZip ?? '',
    addressCity:memberStore.subscriptionDetail?.addressCity ?? ''
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

const nationalRegisterNumberValidator = function (value: string) {
    if (!command.value.newMember) return true;
    return (command.value.nationalRegisterNumber.length === 15);
}

function isNewMember() {
    return command.value.newMember;
}

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
    nationalRegisterNumber: {requiredNewMember: requiredIf(isNewMember), nationalRegisterNumberValidator},
    addressStreet: {requiredNewMember: requiredIf(isNewMember)},
    addressNumber: {requiredNewMember: requiredIf(isNewMember)},
    addressZip: {requiredNewMember: requiredIf(isNewMember)},
    addressCity: {requiredNewMember: requiredIf(isNewMember)},
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
        emit('saved');
    }
}

</script>
