<template>
    <div v-if="step === 0">
        <br><br>
        <div class="text-center">
            <center>
                <svg class="mt-4" width="105" height="105" viewBox="0 0 105 105" xmlns="http://www.w3.org/2000/svg"
                     fill="#ccc">
                    <circle cx="12.5" cy="12.5" r="12.5">
                        <animate attributeName="fill-opacity"
                                 begin="0s" dur="1s"
                                 values="1;.2;1" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                    <circle cx="12.5" cy="52.5" r="12.5" fill-opacity=".5">
                        <animate attributeName="fill-opacity"
                                 begin="100ms" dur="1s"
                                 values="1;.2;1" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                    <circle cx="52.5" cy="12.5" r="12.5">
                        <animate attributeName="fill-opacity"
                                 begin="300ms" dur="1s"
                                 values="1;.2;1" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                    <circle cx="52.5" cy="52.5" r="12.5">
                        <animate attributeName="fill-opacity"
                                 begin="600ms" dur="1s"
                                 values="1;.2;1" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                    <circle cx="92.5" cy="12.5" r="12.5">
                        <animate attributeName="fill-opacity"
                                 begin="800ms" dur="1s"
                                 values="1;.2;1" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                    <circle cx="92.5" cy="52.5" r="12.5">
                        <animate attributeName="fill-opacity"
                                 begin="400ms" dur="1s"
                                 values="1;.2;1" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                    <circle cx="12.5" cy="92.5" r="12.5">
                        <animate attributeName="fill-opacity"
                                 begin="700ms" dur="1s"
                                 values="1;.2;1" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                    <circle cx="52.5" cy="92.5" r="12.5">
                        <animate attributeName="fill-opacity"
                                 begin="500ms" dur="1s"
                                 values="1;.2;1" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                    <circle cx="92.5" cy="92.5" r="12.5">
                        <animate attributeName="fill-opacity"
                                 begin="200ms" dur="1s"
                                 values="1;.2;1" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                </svg>
            </center>
            <div class="mt-4">
                Even geduld...
            </div>
        </div>
    </div>
    <div id="appInschrijving" v-if="step === 1" class="border-2 border-slate-400 rounded-xl p-2">
        <div>
            <div class="url-field-wrapper">
                <o-field class="w-full"
                         label="Url *"
                         label-for="ti_url">
                    <o-input id="ti_url"
                             v-model="subscription.honeyPot"
                             type="text"/>
                </o-field>
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
                <div>
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

        <div class="md:flex md:flex-row mt-2 mb-4 bg-slate-300 p-2 rounded-lg">
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

                <!-- -- geboorte datum ---------------------------------- -->
                <div class="md:flex md:flex-row mt-2">
                    <div class="basis-1/4 text-right mr-4 text-sm mt-8">
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
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right mr-4 text-sm">Geslacht*</div>
                    <div class="basis-3/4">
                        <o-radio id="radio_gender_m" name="gender" native-value="M" v-model="subscription.gender"
                                 variant="info">
                            M
                        </o-radio>
                        <o-radio id="radio_gender_v" name="gender" native-value="V" v-model="subscription.gender"
                                 variant="info">
                            V
                        </o-radio>
                        <o-radio id="radio_gender_x" name="gender" native-value="X" v-model="subscription.gender"
                                 variant="info">
                            X
                        </o-radio>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex flex-row mt-4 mb-4">
            <div class="basis-1/4 mr-4 text-right">&nbsp;</div>
            <div class="basis-3/4">
                <!-- locatie --------------------------------------- -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right mr-4">Locatie</div>
                    <div class="basis-3/4">
                        <div v-for="location in settings.locations" class="mb-1">
                            <o-radio :id="'radio_location_'+location.name"
                                     name="location"
                                     :native-value="location.id"
                                     v-model="subscription.locationId"
                                     variant="info">
                                {{ location.name }}
                            </o-radio>
                        </div>
                    </div>
                </div>
                <!-- duur ------------------------------------------ -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right mr-4">&nbsp;</div>
                    <div class="basis-3/4">
                        <o-radio id="radio_type_full_year" name="type" :native-value="false"
                                 v-model="subscription.memberSubscriptionIsHalfYear" variant="info">
                            Volledig jaar
                        </o-radio>
                        <o-radio id="radio_type_half_year" name="type" :native-value="true"
                                 v-model="subscription.memberSubscriptionIsHalfYear" variant="info">
                            Half jaar
                        </o-radio>
                    </div>
                </div>
                <!-- aantal trainingen  ----------------------------- -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right mr-4">Aantal</div>
                    <div class="basis-3/4">
                        <div>
                            <o-radio id="radio_training_1" name="numberOfTraining" :native-value="1"
                                     v-model="subscription.numberOfTraining" variant="info">
                                1 training per week
                            </o-radio>
                        </div>
                        <div class="mt-2">
                            <o-radio id="radio_training_2" name="numberOfTraining" :native-value="2"
                                     v-model="subscription.numberOfTraining" variant="info">
                                2 trainingen per week
                            </o-radio>
                        </div>
                        <div class="mt-2">
                            <o-radio id="radio_training_3" name="numberOfTraining" :native-value="3"
                                     v-model="subscription.numberOfTraining" variant="info">
                                3 tot 5 trainingen per week
                            </o-radio>
                        </div>
                    </div>
                </div>

                <!-- locatie --------------------------------------- -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right mr-4">Vergunning</div>
                    <div class="basis-3/4">
                        <div v-for="federation in settings.federations" class="mb-1">
                            <o-radio :id="'radio_federation_'+federation.publicLabel"
                                     name="location"
                                     :native-value="federation.id"
                                     v-model="subscription.federationId"
                                     variant="info">
                                {{ federation.publicLabel }}
                            </o-radio>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <hr>
                </div>

                <!-- korting -------------------------------------- -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/4 text-right mr-4">Korting</div>
                    <div class="basis-3/4">
                        <o-field>
                            <o-switch id="radio_reduction" v-model="subscription.reductionFamily" variant="info"
                                      size="small">
                                2e en/of 3e kind van éénzelfde familie
                            </o-switch>
                        </o-field>
                    </div>
                </div>

            </div>
        </div>
        <hr>
        <div class="flex flex-row mt-4 mb-4">
            <div class="basis-1/4 mr-4 text-right">Opmerkingen: </div>
            <div class="basis-3/4">
                <div class="mb-3">
                    Wens je ook een judopak en gordel te bestellen?
                    <br>Geef dan de maat van het judopak en de kleur van de gordel door in het veld hieronder.
                    Dan zorgen wij dat dit klaar ligt bij de volgende training.
                </div>
                <o-field>
                    <o-input id="ta_remarks" v-model="subscription.remarks" maxlength="200" type="textarea"></o-input>
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
                        <o-button id="btn_submit_invalid"
                                  variant="info"
                                  class="w-full"
                                  disabled size="large">
                            Inschrijven
                        </o-button>
                    </div>
                    <div v-else>
                        <o-button id="btn_submit_valid"
                                  variant="info"
                                  class="w-full"
                                  size="large"
                                  @click="subscribe">
                            Inschrijven
                        </o-button>
                    </div>
                    <div class="mt-2">
                        (*) verplichte velden
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="step === 2" class="text-center">
        <center>
            <svg class="mt-4" width="105" height="105" viewBox="0 0 105 105" xmlns="http://www.w3.org/2000/svg"
                 fill="#ccc">
                <circle cx="12.5" cy="12.5" r="12.5">
                    <animate attributeName="fill-opacity"
                             begin="0s" dur="1s"
                             values="1;.2;1" calcMode="linear"
                             repeatCount="indefinite"/>
                </circle>
                <circle cx="12.5" cy="52.5" r="12.5" fill-opacity=".5">
                    <animate attributeName="fill-opacity"
                             begin="100ms" dur="1s"
                             values="1;.2;1" calcMode="linear"
                             repeatCount="indefinite"/>
                </circle>
                <circle cx="52.5" cy="12.5" r="12.5">
                    <animate attributeName="fill-opacity"
                             begin="300ms" dur="1s"
                             values="1;.2;1" calcMode="linear"
                             repeatCount="indefinite"/>
                </circle>
                <circle cx="52.5" cy="52.5" r="12.5">
                    <animate attributeName="fill-opacity"
                             begin="600ms" dur="1s"
                             values="1;.2;1" calcMode="linear"
                             repeatCount="indefinite"/>
                </circle>
                <circle cx="92.5" cy="12.5" r="12.5">
                    <animate attributeName="fill-opacity"
                             begin="800ms" dur="1s"
                             values="1;.2;1" calcMode="linear"
                             repeatCount="indefinite"/>
                </circle>
                <circle cx="92.5" cy="52.5" r="12.5">
                    <animate attributeName="fill-opacity"
                             begin="400ms" dur="1s"
                             values="1;.2;1" calcMode="linear"
                             repeatCount="indefinite"/>
                </circle>
                <circle cx="12.5" cy="92.5" r="12.5">
                    <animate attributeName="fill-opacity"
                             begin="700ms" dur="1s"
                             values="1;.2;1" calcMode="linear"
                             repeatCount="indefinite"/>
                </circle>
                <circle cx="52.5" cy="92.5" r="12.5">
                    <animate attributeName="fill-opacity"
                             begin="500ms" dur="1s"
                             values="1;.2;1" calcMode="linear"
                             repeatCount="indefinite"/>
                </circle>
                <circle cx="92.5" cy="92.5" r="12.5">
                    <animate attributeName="fill-opacity"
                             begin="200ms" dur="1s"
                             values="1;.2;1" calcMode="linear"
                             repeatCount="indefinite"/>
                </circle>
            </svg>
        </center>
        <div class="mt-4">
            Inschrijven...
        </div>
    </div>
    <div v-if="step === 3">
        <br>
        <div class="border-2 border-slate-400 rounded-xl p-2">
            <div class="bg-gray-200 p-4 rounded-lg" style="height:250px">
                <p>
                    We hebben je inschrijving goed ontvangen.
                    <br>We hebben ook een bevestiging verzonden naar <strong>{{
                        subscription.contactEmail
                    }}</strong>.
                    <br>Dit is je referentie
                    "<span data-cy="result-reference">{{ subscriptionResult.reference }}</span>".
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
    type: 'nieuwe-inschrijving',
    federationId: 2,
    locationId: 1,
    contactFirstname: '',
    contactLastname: '',
    contactEmail: '',
    contactPhone: '',
    addressStreet: '',
    addressNumber: '',
    addressBox: '',
    addressZip: '',
    addressCity: '',
    firstname: '',
    lastname: '',
    nationalRegisterNumber: '',
    dateOfBirthDD: '',
    dateOfBirthMM: '',
    dateOfBirthYYYY: '',
    dateOfBirth: new Date(),
    gender: 'X',
    memberSubscriptionIsHalfYear: false,
    numberOfTraining: 1,
    isExtraTraining: false,
    isNewMember: true,
    isReductionFamily: false,
    total: 0,
    remarks: '',
    isJudogiBelt: false,
    honeyPot: '',
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


function loadSettings() {
    axios.get('/inschrijving/api/configuration').then(response => (loadSettingsHandler(response.data)));
}

function loadSettingsHandler(data) {
    settings.value = data;
    step.value = 1;
    subscription.value.locationId = settings.value.locations[0].id;
    subscription.value.federationId = settings.value.federations[0].id;
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
    subscription.value.gender = 'X';
    subscription.value.newMember = true;
    subscription.value.numberOfTraining = 1;
    subscription.value.extraTraining = false;
    subscription.value.reductionFamily = false;
    subscription.value.judogiBelt = false;
    subscription.value.remarks = '';
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

const rules = {
    contactFirstname: {required},
    contactLastname: {required},
    contactEmail: {required, email},
    firstname: {required},
    lastname: {required},
    dateOfBirthDD: {required, numeric, maxValueValue: maxValue(31), minValueValue: minValue(1), dateValidator},
    dateOfBirthMM: {required, numeric, maxValueValue: maxValue(12), minValueValue: minValue(1), dateValidator},
    dateOfBirthYYYY: {required, numeric, minValueValue: minValue(1900), maxValueValue: maxValue(2400), dateValidator},
    addressStreet: {required},
    addressNumber: {required},
    addressZip: {required},
    addressCity: {required},
    locationId: {minValueValue: minValue(1)},
    federationId: {minValueValue: minValue(1)},
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
