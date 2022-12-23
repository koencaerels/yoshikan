<template>
    <div id="subscriptionAdd" style="width: 600px;" class="text-sm">

        <div class="flex flex-row mt-2">
            <div class="basis-1/2">
                <div class="mb-1"><label>Contact voornaam *</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="subscription.contactFirstname"/>
                    <i v-if="!add$.contactFirstname.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="add$.contactFirstname.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/2 ml-4">
                <div class="mb-1"><label>Contact naam *</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="subscription.contactLastname"/>
                    <i v-if="!add$.contactLastname.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="add$.contactLastname.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/2">
                <div class="mb-1"><label>Contact email *</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="subscription.contactEmail"/>
                    <i v-if="!add$.contactEmail.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="add$.contactEmail.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/2 ml-4">
                <div class="mb-1"><label>Contact telefoon</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="subscription.contactPhone"/>
                </span>
            </div>
        </div>

        <div class="mt-3">
            <hr>
        </div>

        <div class="flex flex-row mt-2">
            <div class="basis-1/2">
                <div class="mb-1"><label>Judoka voornaam *</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="subscription.firstname"/>
                    <i v-if="!add$.firstname.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="add$.firstname.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/2 ml-4">
                <div class="mb-1"><label>Judoka naam *</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="subscription.lastname"/>
                    <i v-if="!add$.lastname.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="add$.lastname.$invalid" class="pi pi-times text-red-600"/>
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
                    <InputText class="w-full p-inputtext-sm" v-model="subscription.dateOfBirthDD"/>
                    <i v-if="!add$.dateOfBirthDD.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="add$.dateOfBirthDD.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/4 ml-4">
                <div class="mb-1"><label> / MM</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="subscription.dateOfBirthMM"/>
                    <i v-if="!add$.dateOfBirthMM.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="add$.dateOfBirthMM.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/4 ml-4">
                <div class="mb-1"><label> / YYYY</label></div>
                <span class="p-input-icon-right w-full">
                    <InputText class="w-full p-inputtext-sm" v-model="subscription.dateOfBirthYYYY"/>
                    <i v-if="!add$.dateOfBirthYYYY.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="add$.dateOfBirthYYYY.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
        </div>

        <div class="flex flex-row mt-4">
            <div class="basis-1/4 text-right">
                Geslacht *
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

        <div class="mt-3">
            <hr>
        </div>

        <div class="flex flex-row mt-4">
            <div class="basis-1/4 text-right">
                Nieuw lid
            </div>
            <div class="basis-3/4 ml-4">
                <span>
                    <RadioButton name="newMember" :value="true" v-model="subscription.newMember" input-id="yes"/>
                    <label for="yes"> Ja </label>
                </span>
                <span class="ml-2">
                    <RadioButton name="newMember" :value="false" v-model="subscription.newMember" input-id="no"/>
                    <label for="no"> Nee </label>
                </span>
            </div>
        </div>
        <div class="flex flex-row mt-4">
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
        <div class="flex flex-row mt-4">
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
        <div class="flex flex-row mt-4">
            <div class="basis-1/4 text-right">
                Aantal trainingen
            </div>
            <div class="basis-3/4 ml-4">
                <span>
                    <RadioButton name="numberOfTraining" :value="1" v-model="subscription.numberOfTraining"
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

        <div class="mt-3">
            <hr>
        </div>
        <div class="flex flex-row mt-4">
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
                <Textarea v-model="subscription.remarks" :autoResize="true" rows="2" cols="30" class="w-full"/>
            </div>
        </div>

        <div class="text-xs"><code>{{ subscription }}</code></div>

        <div class="mt-3">
            <hr>
        </div>
        <div class="flex flex-row mt-4">
            <div class="basis-1/4 text-right">&nbsp;</div>
            <div class="basis-1/2 ml-4">
                <Button label="Schrijf in"
                        :disabled="add$.$invalid"
                        icon="pi pi-save"
                        class="w-full p-button-success"/>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {onMounted, ref} from "vue";
import {email, maxValue, minValue, numeric, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";

const appStore = useAppStore();
const emit = defineEmits(["subscribed"]);

onMounted(() => {
    add$.value.$touch();
});

const subscription = ref({
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
    gender: 'M',
    newMember: true,
    location: appStore.configuration?.locations[0].id ?? 0,
    type: 'full',
    numberOfTraining: 1,
    extraTraining: false,
    reductionFamily: false,
    judogiBelt: false,
    remarks: '',
    honeyPot: ''
});

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
    dateOfBirthYYYY: {required, numeric, minValueValue: minValue(1900), maxValueValue: maxValue(2200), dateValidator},
    location: {minValueValue: minValue(1)},
};

const add$ = useVuelidate(rules, subscription);

// -- save subscription ---------------------------------------

const isSaving = ref<boolean>(false);

async function subscribe() {
    add$.value.$touch();
    if (!add$.$invalid) {
        isSaving.value = true;
        // todo subscribe to the backend
        emit('subscribed');
    }
}

</script>
