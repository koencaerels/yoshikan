<template>
    <div id="subscriptionAdd" style="width: 1200px;" class="text-sm">

        <div class="flex flex-row">
            <!-- column 1 -->
            <div class="basis-1/2">

                <div class="flex bg-slate-200 p-2 rounded-lg">
                    <div>
                        <div v-if="subscription.newMember"><i class="pi pi-user-plus"></i></div>
                        <div v-else><i class="pi pi-refresh"></i></div>
                    </div>
                    <div class="ml-4">
                        <strong>Nieuw lid?</strong>
                    </div>
                    <div class="ml-4">
                        <span>
                            <RadioButton name="newMember" :value="true" v-model="subscription.newMember" input-id="yes"/>
                            <label for="yes"><strong> Ja </strong></label>
                        </span>
                        <span class="ml-2">
                            <RadioButton name="newMember" :value="false" v-model="subscription.newMember" input-id="no"/>
                            <label for="no"><strong> Nee </strong></label>
                        </span>
                    </div>
                </div>

                <div class="flex flex-row mt-2">
                    <div class="basis-1/2">
                        <div class="mb-1"><label class="text-xs">Contact voornaam *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="subscription.contactFirstname"/>
                            <i v-if="!add$.contactFirstname.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="add$.contactFirstname.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                    <div class="basis-1/2 ml-4">
                        <div class="mb-1"><label class="text-xs">Contact naam *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="subscription.contactLastname"/>
                            <i v-if="!add$.contactLastname.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="add$.contactLastname.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                </div>
                <div class="flex flex-row mt-1">
                    <div class="basis-1/2">
                        <div class="mb-1"><label class="text-xs">Contact email *</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="subscription.contactEmail"/>
                            <i v-if="!add$.contactEmail.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="add$.contactEmail.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                    <div class="basis-1/2 ml-4">
                        <div class="mb-1"><label class="text-xs">Contact telefoon</label></div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="subscription.contactPhone"/>
                        </span>
                    </div>
                </div>

                <!-- -- adres -------------------------------------------------------------------------------------- -->
                <div v-if="subscription.newMember"><!--  -->
                    <div class="flex flex-row mt-1">
                        <div class="basis-3/5">
                            <div class="mb-1"><label class="text-xs">Straat *</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="subscription.addressStreet"/>
                                <i v-if="!add$.addressStreet.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="add$.addressStreet.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                        <div class="basis-1/5 ml-2">
                            <div class="mb-1"><label class="text-xs">Nummer *</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="subscription.addressNumber"/>
                                <i v-if="!add$.addressNumber.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="add$.addressNumber.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                        <div class="basis-1/5 ml-2">
                            <div class="mb-1"><label class="text-xs">Bus</label></div>
                            <InputText class="w-full p-inputtext-sm" v-model="subscription.addressBox"/>
                        </div>
                    </div>
                    <div class="flex flex-row mt-1">
                        <div class="basis-1/4">
                            <div class="mb-1"><label class="text-xs">Postcode *</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="subscription.addressZip"/>
                                <i v-if="!add$.addressZip.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="add$.addressZip.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                        <div class="basis-3/4 ml-2">
                            <div class="mb-1"><label class="text-xs">Gemeente *</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="subscription.addressCity"/>
                                <i v-if="!add$.addressCity.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="add$.addressCity.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                    </div>
                </div>

                <div v-if="!subscription.newMember">&nbsp;</div>

                <!-- judoka -->
                <div class="bg-slate-200 p-2 mt-2 rounded-lg pb-3">
                    <div class="flex flex-row">
                        <div class="basis-1/2">
                            <div class="mb-1"><label><strong>Judoka voornaam *</strong></label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="subscription.firstname"/>
                                <i v-if="!add$.firstname.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="add$.firstname.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                        <div class="basis-1/2 ml-4">
                            <div class="mb-1"><label><strong>Judoka naam *</strong></label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="subscription.lastname"/>
                                <i v-if="!add$.lastname.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="add$.lastname.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                    </div>

                    <!-- -- rijksregisternummer -------------------------------------------------------------------- -->
                    <div class="flex flex-row mt-2" v-if="subscription.newMember">
                        <div class="basis-1/4 text-right mr-2 text-sm mt-2">
                            Rijksregisternummer*
                        </div>
                        <div class="basis-3/4">
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm"
                                           v-on:input="onChangeNationalNumber"
                                           maxlength="15"
                                           v-maska
                                           data-maska="#0.#0.#0-#00.#0"
                                           data-maska-tokens="0:[0-9]:req"
                                           v-model="subscription.nationalRegisterNumber"/>
                                <i v-if="!add$.nationalRegisterNumber.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="add$.nationalRegisterNumber.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-row mt-2">
                        <div class="basis-1/4 text-right">
                            Geboortedatum*
                        </div>
                        <div class="basis-1/4 ml-4">
                            <div class="mb-1"><label class="text-xs">DD</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="subscription.dateOfBirthDD"/>
                                <i v-if="!add$.dateOfBirthDD.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="add$.dateOfBirthDD.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                        <div class="basis-1/4 ml-4">
                            <div class="mb-1"><label class="text-xs"> / MM</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="subscription.dateOfBirthMM"/>
                                <i v-if="!add$.dateOfBirthMM.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="add$.dateOfBirthMM.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                        <div class="basis-1/4 ml-4">
                            <div class="mb-1"><label class="text-xs"> / YYYY</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="subscription.dateOfBirthYYYY"/>
                                <i v-if="!add$.dateOfBirthYYYY.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="add$.dateOfBirthYYYY.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-row mt-4">
                        <div class="basis-1/4 text-right">
                            Geslacht*
                        </div>
                        <div class="basis-1/2 ml-4">
                            <span>
                                <RadioButton name="gender" value="M" v-model="subscription.gender" input-id="M"/>
                                <label for="M"> M </label>
                            </span>
                            <span class="ml-2">
                                <RadioButton name="gender" value="V" v-model="subscription.gender" input-id="V"/>
                                <label for="V"> V </label>
                            </span>
                            <span class="ml-2">
                                <RadioButton name="gender" value="X" v-model="subscription.gender" input-id="X"/>
                                <label for="X"> X </label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- --------------------------------------------------------------------------------------------------- -->
            <!-- column 2                                                                                            -->
            <!-- --------------------------------------------------------------------------------------------------- -->
            <div class="basis-1/2 ml-2">
                <div class="flex flex-row mt-2">
                    <div class="basis-1/4 text-right">
                        Locatie
                    </div>
                    <div class="basis-3/4 ml-4">
                        <div v-if="appStore.configuration">
                            <span v-for="location in appStore.configuration.locations" class="mr-4">
                                <RadioButton name="location" :value="location.id"
                                         v-model="subscription.location"
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
                            <RadioButton name="type" value="full" v-model="subscription.type" input-id="full"/>
                            <label for="yes"> Volledig jaar </label>
                        </span>
                        <span class="ml-2">
                            <RadioButton name="type" value="half" v-model="subscription.type" input-id="half"/>
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
                            <RadioButton name="numberOfTraining" :value="1"
                                         v-model="subscription.numberOfTraining"
                                     input-id="1times"/>
                                <label for="1times"> 1 keer per week </label>
                        </span>
                        <span class="ml-2">
                            <RadioButton name="numberOfTraining" :value="2" v-model="subscription.numberOfTraining"
                                     input-id="2times"/>
                            <label for="2times"> 2 keer per week </label>
                        </span>
                        <span class="ml-2">
                            <RadioButton name="numberOfTraining" :value="3" v-model="subscription.numberOfTraining"
                                 input-id="3times"/>
                            <label for="3times"> 3 tot 5 keer per week </label>
                        </span>
                    </div>
                </div>
                <div class="mt-6">
                    <hr>
                </div>
                <div class="flex flex-row mt-6">
                    <div class="basis-1/4 text-right">
                        Judopak + gordel
                    </div>
                    <div class="basis-1/4 ml-4">
                        <InputSwitch v-model="subscription.judogiBelt"/>
                    </div>
                    <div class="basis-1/4 text-right">
                        Gezinskorting
                    </div>
                    <div class="basis-1/4 ml-4">
                        <InputSwitch v-model="subscription.reductionFamily"/>
                    </div>
                </div>
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right">
                        Opmerkingen
                    </div>
                    <div class="basis-3/4 ml-4">
                        <Textarea v-model="subscription.remarks" :autoResize="true" rows="5" cols="30" class="w-full"/>
                    </div>
                </div>
                <div class="flex flex-row mt-6">
                    <div class="basis-1/4 text-right">&nbsp;</div>
                    <div class="basis-3/4 ml-4 text-right">
                        <Button v-if="!isSaving"
                                label="Schrijf in"
                                :disabled="add$.$invalid"
                                icon="pi pi-save"
                                @click="subscribe"
                                class="w-full p-button-success p-button-lg"/>
                        <Button v-else label="Schrijf in"
                                disabled
                                icon="pi pi-spinner pi-spin"
                                class="w-full p-button-success p-button-lg"/>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {onMounted, ref} from "vue";
import {email, maxValue, minValue, numeric, required, requiredIf} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {subscribeAction} from "@/api/command/subscribeAction";
import {useMemberStore} from "@/store/member";
import moment from "moment/moment";
import {useToast} from "primevue/usetoast";
import {vMaska} from "maska";

const toaster = useToast();
const appStore = useAppStore();
const memberStore = useMemberStore();
const emit = defineEmits(["subscribed"]);
const props = defineProps<{
    memberId: number,
}>();

onMounted(() => {
    add$.value.$touch();
    if (props.memberId != 0 && memberStore.memberDetail) {
        subscription.value.firstname = memberStore.memberDetail.firstname;
        subscription.value.lastname = memberStore.memberDetail.lastname;
        subscription.value.gender = memberStore.memberDetail.gender;
        subscription.value.newMember = false;
        subscription.value.location = memberStore.memberDetail.location.id;
        subscription.value.dateOfBirth = new Date(memberStore.memberDetail.dateOfBirth);
        subscription.value.dateOfBirthDD = moment(memberStore.memberDetail.dateOfBirth).format("DD");
        subscription.value.dateOfBirthMM = moment(memberStore.memberDetail.dateOfBirth).format("MM");
        subscription.value.dateOfBirthYYYY = moment(memberStore.memberDetail.dateOfBirth).format("YYYY");
    }
});

const subscription = ref({
    memberId: props.memberId,
    periodId: appStore.configuration?.activePeriod.id ?? 0,
    contactFirstname: '',
    contactLastname: '',
    contactEmail: '',
    contactPhone: '',
    firstname: '',
    lastname: '',
    dateOfBirthDD: '',
    dateOfBirthMM: '',
    dateOfBirthYYYY: '',
    dateOfBirth: new Date(),
    gender: 'X',
    newMember: true,
    location: appStore.configuration?.locations[0].id ?? 0,
    type: 'full',
    numberOfTraining: 1,
    extraTraining: false,
    reductionFamily: false,
    judogiBelt: false,
    remarks: '',
    honeyPot: '',
    nationalRegisterNumber: '',
    addressStreet: '',
    addressNumber: '',
    addressBox: '',
    addressZip: '',
    addressCity: ''
});

// -- validation ---------------------------------------

const dateValidator = function (value: string) {
    if (subscription.value.dateOfBirthDD.length !== 0
        && subscription.value.dateOfBirthMM.length !== 0
        && subscription.value.dateOfBirthYYYY.length !== 0
    ) {
        try {
            let dateOfBirth = new Date(
                parseInt(subscription.value.dateOfBirthYYYY),
                parseInt(subscription.value.dateOfBirthMM) - 1,
                parseInt(subscription.value.dateOfBirthDD),
                8,
                0,
                0,
                0
            );
            subscription.value.dateOfBirth = dateOfBirth;
        } catch (error) {
            return false;
        }
    }
    return true;
};

const nationalRegisterNumberValidator = function (value:string) {
    if (!subscription.value.newMember) return true;
    return (subscription.value.nationalRegisterNumber.length === 15);
}

function isNewMember() {
    return subscription.value.newMember;
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
    location: {minValueValue: minValue(1)},
    nationalRegisterNumber: {requiredNewMember: requiredIf(isNewMember), nationalRegisterNumberValidator},
    addressStreet: {requiredNewMember: requiredIf(isNewMember)},
    addressNumber: {requiredNewMember: requiredIf(isNewMember)},
    addressZip: {requiredNewMember: requiredIf(isNewMember)},
    addressCity: {requiredNewMember: requiredIf(isNewMember)},
};

const add$ = useVuelidate(rules, subscription);

// -- save subscription ---------------------------------------

const isSaving = ref<boolean>(false);

async function subscribe() {
    add$.value.$touch();
    if (!add$.value.$invalid) {
        isSaving.value = true;
        await subscribeAction(subscription.value);
        isSaving.value = false;
        toaster.add({
            severity: "success",
            summary: "Inschrijving aangemaakt.",
            detail: "",
            life: appStore.toastLifeTime,
        });
        emit('subscribed');
    }
}

function onChangeNationalNumber() {
    if (subscription.value.nationalRegisterNumber.length === 2) {
        let _year = parseInt(subscription.value.nationalRegisterNumber);
        if (_year > 50) {
            subscription.value.dateOfBirthYYYY = '19' + _year;
        } else {
            subscription.value.dateOfBirthYYYY = '20' + _year;
        }
    } else if (subscription.value.nationalRegisterNumber.length === 5) {
        let _month = subscription.value.nationalRegisterNumber.split('.')[1];
        subscription.value.dateOfBirthMM = _month;
    } else if (subscription.value.nationalRegisterNumber.length === 8) {
        let _day = subscription.value.nationalRegisterNumber.split('.')[2];
        subscription.value.dateOfBirthDD = _day;
    } else if (subscription.value.nationalRegisterNumber.length === 12) {
        let _dayNumber = subscription.value.nationalRegisterNumber.split('-')[1];
        let _dayNumberMod = parseInt(_dayNumber) % 2;
        if (_dayNumberMod === 0) {
            subscription.value.gender = 'V';
        } else {
            subscription.value.gender = 'M';
        }
    }
}

</script>
