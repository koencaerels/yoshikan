<template>
    <div v-if="step === 0">
        Loading settings...
    </div>
    <div id="appInschrijving" v-if="step === 1" class="border-2 border-slate-400 rounded-xl p-2">

        <div class="bg-gray-200 pt-0.5 pb-3 rounded-t-lg">
            <div class="flex flex-row mt-4 mb-4">
                <div class="basis-1/4 mr-4 text-right">
                    <span class="text-xl"><strong>Periode&nbsp;&nbsp;</strong></span>
                    <i class="mdi mdi-calendar text-2xl"></i>
                </div>
                <div class="basis-3/4 text-xl">
                    <strong>{{ settings.activePeriod.name }}</strong>
                </div>
            </div>
            <div class="url-field-wrapper">
                <o-input id="ti_url"
                         v-model="subscription.honeyPot"
                         type="text"/>
            </div>
            <!-- nieuw lid ------------------------------------------ -->
            <div class="flex flex-row">
                <div class="basis-1/4 text-right mr-4 text-lg">Nieuw lid?</div>
                <div class="basis-3/4">
                    <o-radio name="newMember" :native-value="true" size-class="large"
                             v-model="subscription.newMember" variant="info">
                        <span class="text-lg">Ja</span>
                    </o-radio>
                    <o-radio name="newMember" :native-value="false" size-class="large"
                             v-model="subscription.newMember" variant="info">
                        <span class="text-lg">Nee</span>
                    </o-radio>
                </div>
            </div>
        </div>

        <!-- -- contact ----------------------------------------- -->
        <div class="md:flex md:flex-row mt-2 mb-4">
            <div class="basis-1/4 mr-4 text-right">
                <span><strong>Contact&nbsp;&nbsp;</strong></span>
                <i class="mdi mdi-email text-2xl"></i>
            </div>
            <div class="basis-3/4">
                <div class="md:flex md:flex-row">
                    <div class="basis-1/2">
                        <o-field class="w-full"
                                 label="Voornaam *"
                                 :variant="contactFirstnameVariant"
                                 label-for="ti_firstname">
                            <o-input id="ti_firstname"
                                     v-model="subscription.contactFirstname"
                                     type="text"/>
                        </o-field>
                    </div>
                    <div class="basis-1/2 md:ml-2">
                        <o-field class="w-full"
                                 label="Naam *"
                                 :variant="contactLastnameVariant"
                                 label-for="ti_lastname">
                            <o-input id="ti_lastname"
                                     v-model="subscription.contactLastname" type="text"/>
                        </o-field>
                    </div>
                </div>
                <div class="md:flex md:flex-row mt-2">
                    <div class="basis-1/2">
                        <o-field class="w-full" :variant="contactEmailVariant" label="Email *" label-for="ti_email">
                            <o-input id="ti_email" v-model="subscription.contactEmail" type="text"/>
                        </o-field>
                    </div>
                    <div class="basis-1/2 md:ml-2">
                        <o-field class="w-full" label="Telefoon" label-for="ti_mobile">
                            <o-input id="ti_mobile" v-model="subscription.contactPhone" type="text"/>
                        </o-field>
                    </div>
                </div>

                <!-- -- adres -------------------------------------- -->
                <div v-if="subscription.newMember"><!--  -->
                    <div class="md:flex md:flex-row mt-2">
                        <div class="basis-3/5">
                            <o-field class="w-full" :variant="addressStreetVariant" label="Straat *"
                                     label-for="ti_street">
                                <o-input id="ti_street" v-model="subscription.addressStreet" type="text"/>
                            </o-field>
                        </div>
                        <div class="basis-1/5 md:ml-2">
                            <o-field class="w-full" :variant="addressNumberVariant" label="Nummer *"
                                     label-for="ti_street_number">
                                <o-input id="ti_street_number" v-model="subscription.addressNumber" type="text"/>
                            </o-field>
                        </div>
                        <div class="basis-1/5 md:ml-2">
                            <o-field class="w-full" label="Bus" label-for="ti_street_box">
                                <o-input id="ti_street_box" v-model="subscription.addressBox" type="text"/>
                            </o-field>
                        </div>
                    </div>
                    <div class="md:flex md:flex-row mt-2">
                        <div class="basis-1/4">
                            <o-field class="w-full" :variant="addressZipVariant" label="Postcode *"
                                     label-for="ti_postal_code">
                                <o-input id="ti_postal_code" v-model="subscription.addressZip" type="text"/>
                            </o-field>
                        </div>
                        <div class="basis-3/4 md:ml-2">
                            <o-field class="w-full" :variant="addressCityVariant" label="Gemeente *"
                                     label-for="ti_city">
                                <o-input id="ti_city" v-model="subscription.addressCity" type="text"/>
                            </o-field>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <hr>
        <div class="md:flex md:flex-row mt-2 mb-4">
            <div class="basis-1/4 mr-4 text-right">
                <span><strong>Judoka&nbsp;&nbsp;</strong></span>
                <i class="mdi mdi-account-circle text-2xl"></i>
            </div>
            <div class="basis-3/4">

                <!-- -- judoka ----------------------------------------- -->
                <div class="md:flex md:flex-row">
                    <div class="basis-1/2">
                        <o-field class="w-full" :variant="firstnameVariant" label="Voornaam *"
                                 label-for="ti_judoka_firstname">
                            <o-input id="ti_judoka_firstname" v-model="subscription.firstname" type="text"/>
                        </o-field>
                    </div>
                    <div class="basis-1/2 md:ml-2">
                        <o-field class="w-full" :variant="lastnameVariant" label="Naam *"
                                 label-for="ti_judoka_lastname">
                            <o-input id="ti_judoka_lastname" v-model="subscription.lastname" type="text"/>
                        </o-field>
                    </div>
                </div>

                <!-- -- rijksregisternummer ----------------------- -->
                <div class="flex flex-row mt-4" v-if="subscription.newMember"> <!--   -->
                    <div class="basis-1/4 text-right mr-4 text-sm mt-2">
                        Rijksregisternummer*
                    </div>
                    <div class="basis-3/4">
                        <o-field class="w-full" :variant="nationalRegisterNumberVariant">
                            <o-input id="ti_national_number"
                                     v-on:input="onChangeNationalNumber"
                                     v-maska
                                     v-model="subscription.nationalRegisterNumber"
                                     maxlength="15"
                                     data-maska="#0.#0.#0-#00.#0"
                                     data-maska-tokens="0:[0-9]:req"
                                     type="text"/>
                        </o-field>
                    </div>
                </div>

                <!-- -- geboorte datum ---------------------------------- -->
                <div class="md:flex md:flex-row mt-2">
                    <div class="basis-1/4 text-right mr-4 text-sm">
                        Geboortedatum*
                    </div>
                    <div class="basis-2/12">
                        <o-field class="w-full" :variant="dateOfBirthDDVariant" label="dd" label-for="ti_day">
                            <o-input id="ti_day" v-model="subscription.dateOfBirthDD" type="text" maxlength="2"/>
                        </o-field>
                    </div>
                    <div class="basis-1/12 text-center">/</div>
                    <div class="basis-2/12 md:ml-2">
                        <o-field class="w-full" :variant="dateOfBirthMMVariant" label="mm" label-for="ti_month">
                            <o-input id="ti_month" v-model="subscription.dateOfBirthMM" type="text" maxlength="2"/>
                        </o-field>
                    </div>
                    <div class="basis-1/12 text-center">/</div>
                    <div class="basis-1/4 md:ml-2">
                        <o-field class="w-full" :variant="dateOfBirthYYYVariant" label="yyyy" label-for="ti_year">
                            <o-input id="ti_year"
                                     v-maska:[options]
                                     data-maska="####"
                                     v-model="subscription.dateOfBirthYYYY"
                                     maxlength="4"
                                     type="text"/>
                        </o-field>
                    </div>
                </div>

                <!-- gender --------------------------------------- -->
                <div class="flex flex-row mt-4" v-if="subscription.newMember"> <!-- -->
                    <div class="basis-1/4 text-right mr-4 text-sm">Geslacht*</div>
                    <div class="basis-3/4">
                        <o-radio name="gender" native-value="M" v-model="subscription.gender" variant="info">
                            M
                        </o-radio>
                        <o-radio name="gender" native-value="V" v-model="subscription.gender" variant="info">
                            V
                        </o-radio>
                        <o-radio name="gender" native-value="X" v-model="subscription.gender" variant="info">
                            X
                        </o-radio>
                    </div>
                </div>

            </div>
        </div>

        <hr>
        <div class="flex flex-row mt-4 mb-4">
            <div class="basis-1/4 mr-4 text-right">&nbsp;</div>
            <div class="basis-3/4">
                <!-- locatie --------------------------------------- -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right mr-4">Locatie</div>
                    <div class="basis-3/4">
                        <span v-for="location in settings.locations">
                            <o-radio name="location"
                                     :native-value="location.id"
                                     v-model="subscription.location"
                                     variant="info">
                                {{ location.name }}
                            </o-radio>
                        </span>
                    </div>
                </div>
                <!-- duur ------------------------------------------ -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right mr-4">Type</div>
                    <div class="basis-3/4">
                        <o-radio name="type" native-value="full"
                                 v-model="subscription.type" variant="info">
                            Volledig jaar
                        </o-radio>
                        <o-radio name="type" native-value="half"
                                 v-model="subscription.type" variant="info">
                            Half jaar
                        </o-radio>
                    </div>
                </div>
                <!-- aantal trainingen  ----------------------------- -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right mr-4">Aantal</div>
                    <div class="basis-3/4">
                        <div>
                            <o-radio name="numberOfTraining" :native-value="1"
                                     v-model="subscription.numberOfTraining" variant="info">
                                1 training per week
                            </o-radio>
                        </div>
                        <div class="mt-2">
                            <o-radio name="numberOfTraining" :native-value="2"
                                     v-model="subscription.numberOfTraining" variant="info">
                                2 trainingen per week
                            </o-radio>
                        </div>
                        <div class="mt-2">
                            <o-radio name="numberOfTraining" :native-value="3"
                                     v-model="subscription.numberOfTraining" variant="info">
                                3 tot 5 trainingen per week
                            </o-radio>
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    <hr>
                </div>

                <!-- kledij -------------------------------------- -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right mr-4">Judopak</div>
                    <div class="basis-3/4">
                        <o-field>
                            <o-switch v-model="subscription.judogiBelt" variant="info" size="small">
                                Judopak + gordel
                            </o-switch>
                        </o-field>
                    </div>
                </div>

                <!-- korting -------------------------------------- -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right mr-4">Korting</div>
                    <div class="basis-3/4">
                        <o-field>
                            <o-switch v-model="subscription.reductionFamily" variant="info" size="small">
                                2e en/of 3e kind van éénzelfde familie
                            </o-switch>
                        </o-field>
                    </div>
                </div>

            </div>
        </div>
        <!-- calculation --------------------------------------- -->
        <!--        <hr>-->
        <!--        <div class="flex flex-row mt-4 mb-4">-->
        <!--            <div class="basis-1/4 mr-4 text-right text-xl"><strong>Totaal :</strong></div>-->
        <!--            <div class="basis-3/4 text-xl">-->
        <!--                (260 € - 10%) + 10 € + 50 € = <strong>294 €</strong>-->
        <!--                (+ judopak en gordel)-->
        <!--            </div>-->
        <!--        </div>-->
        <!-- remarks ------------------------------------------- -->
        <hr>
        <div class="flex flex-row mt-4 mb-4">
            <div class="basis-1/4 mr-4 text-right">Opmerkingen</div>
            <div class="basis-3/4">
                <o-field>
                    <o-input v-model="subscription.remarks" maxlength="200" type="textarea"></o-input>
                </o-field>
            </div>
        </div>
        <hr>
        <!-- subscribe button --------------------------------- -->
        <div class="bg-gray-200 pt-0.5 pb-3 rounded-b-lg">
            <div class="flex flex-row mt-4 mb-4">
                <div class="basis-1/4 mr-4 text-right">&nbsp;</div>
                <div class="basis-2/4">
                    <div v-if="v$.$invalid">
                        <o-button variant="info" class="w-full" disabled size="large">
                            Inschrijven
                        </o-button>
                    </div>
                    <div v-else>
                        <o-button variant="info" class="w-full" size="large"
                                  @click="subscribe">
                            Inschrijven
                        </o-button>
                    </div>
                    <div class="mt-2 text-xs">
                        (*) verplichte velden
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="text-xs"><code>{{ subscription }}</code></div>-->
    </div>

    <div v-if="step === 2">
        <div style="height: 250px">
            Inschrijven...
        </div>
    </div>
    <div v-if="step === 3">
        <br>
        <div class="border-2 border-slate-400 rounded-xl p-2">
            <div class="bg-gray-200 p-4 rounded-lg" style="height:250px">
                <p>
                    We hebben je inschrijving goed ontvangen.
                    <br>We hebben ook een email als bevestiging verzonden naar <strong>{{
                        subscription.contactEmail
                    }}</strong>.
                    <br>Dit is je referentie "{{ subscriptionResult.reference }}".
                </p>
                <p>
                <span class="underline text-blue-700 cursor-pointer"
                      @click="resetSubscription">Nog een inschrijving?</span>
                </p>
            </div>
        </div>
    </div>

</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import useVuelidate from "@vuelidate/core";
import {minValue, required, email, numeric, maxValue, requiredIf} from "@vuelidate/validators";
import {vMaska} from "maska"
import axios from "axios";

const step = ref(0);
const isSaving = ref(false);
const settings = ref({});
const subscription = ref({
    periodId: 0,
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
    location: 1,
    type: 'full',
    numberOfTraining: 1,
    extraTraining: false,
    reductionFamily: false,
    judogiBelt: false,
    remarks: '',
    honeyPot: '',
    // extra fields for a subscription (only for new members)
    newMember: true,
    gender: 'X',
    nationalRegisterNumber: '',
    addressStreet: '',
    addressNumber: '',
    addressBox: '',
    addressZip: '',
    addressCity: ''
});
const subscriptionResult = ref({});
const options = {
    postProcess: val => {
        const max = "" + new Date().getFullYear()
        return val > max ? max : val
    }
}

onMounted(() => {
    v$.value.$touch();
    loadSettings();
});

function onChangeNationalNumber() {
    if (subscription.value.nationalRegisterNumber.length === 2) {
        let _year = subscription.value.nationalRegisterNumber;
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

function loadSettings() {
    axios.get('/inschrijving/api/configuration').then(response => (loadSettingsHandler(response.data)));
}

function loadSettingsHandler(data) {
    settings.value = data;
    step.value = 1;
    subscription.value.periodId = settings.value.activePeriod.id;
    subscription.value.location = settings.value.locations[0].id;
}

function subscribe() {
    v$.value.$touch();
    if (!v$.$invalid) {
        step.value = 2;
        const formData = new FormData();
        formData.append('subscription', JSON.stringify(subscription.value));
        axios.post('/inschrijving/api/subscribe', formData).then(response => (subscribeHandler(response.data)));
    }
}

function subscribeHandler(data) {
    step.value = 3;
    subscriptionResult.value = data;
}

function resetSubscription() {
    subscription.value.contactFirstname = '';
    subscription.value.contactLastname = '';
    subscription.value.contactEmail = '';
    subscription.value.contactPhone = '';
    subscription.value.firstname = '';
    subscription.value.lastname = '';
    subscription.value.dateOfBirthDD = '';
    subscription.value.dateOfBirthMM = '';
    subscription.value.dateOfBirthYYYY = '';
    subscription.value.dateOfBirth = new Date();
    subscription.value.gender = 'M';
    subscription.value.newMember = true;
    subscription.value.type = 'full';
    subscription.value.numberOfTraining = 1;
    subscription.value.extraTraining = false;
    subscription.value.reductionFamily = false;
    subscription.value.judogiBelt = false;
    subscription.value.remarks = '';
    // reset the extra fields
    subscription.value.nationalRegisterNumber = '';
    subscription.value.addressStreet = '';
    subscription.value.addressNumber = '';
    subscription.value.addressBox = '';
    subscription.value.addressZip = '';
    subscription.value.addressCity = '';

    step.value = 1;
}

// -- validation ---------------------------------------

const dateValidator = function (value) {
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

const nationalRegisterNumberValidator = function (value) {
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

const v$ = useVuelidate(rules, subscription);

const contactFirstnameVariant = computed(() => v$.value.contactFirstname.$invalid === false ? 'success' : 'danger');
const contactLastnameVariant = computed(() => v$.value.contactLastname.$invalid === false ? 'success' : 'danger');
const contactEmailVariant = computed(() => v$.value.contactEmail.$invalid === false ? 'success' : 'danger');
const firstnameVariant = computed(() => v$.value.firstname.$invalid === false ? 'success' : 'danger');
const lastnameVariant = computed(() => v$.value.lastname.$invalid === false ? 'success' : 'danger');
const dateOfBirthDDVariant = computed(() => v$.value.dateOfBirthDD.$invalid === false ? 'success' : 'danger');
const dateOfBirthMMVariant = computed(() => v$.value.dateOfBirthMM.$invalid === false ? 'success' : 'danger');
const dateOfBirthYYYVariant = computed(() => v$.value.dateOfBirthYYYY.$invalid === false ? 'success' : 'danger');
const nationalRegisterNumberVariant = computed(() => v$.value.nationalRegisterNumber.$invalid === false ? 'success' : 'danger');
const addressStreetVariant = computed(() => v$.value.addressStreet.$invalid === false ? 'success' : 'danger');
const addressNumberVariant = computed(() => v$.value.addressNumber.$invalid === false ? 'success' : 'danger');
const addressZipVariant = computed(() => v$.value.addressZip.$invalid === false ? 'success' : 'danger');
const addressCityVariant = computed(() => v$.value.addressCity.$invalid === false ? 'success' : 'danger');

</script>

<style>

.o-field__label {
    font-weight: normal !important;
    color: #4f4f4f;
}

.o-input__icon-right {
    color: #DDD;
}

.o-input--danger {
    border-color: silver;
}

.o-input--success {
    border-color: forestgreen;
}

</style>
