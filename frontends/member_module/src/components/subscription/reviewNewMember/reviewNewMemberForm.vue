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
    <div style="width:1250px;">

        <!-- ------------------------------------------------------------------------------------------------------- -->
        <!-- STEP 1                                                                                                  -->
        <!-- ------------------------------------------------------------------------------------------------------- -->

        <div class="flex flex-row" v-if="(currentStep===1)">

            <div class="basis-1/2">

                <!-- -- suggest members ---------------------------------------------------------------------------- -->
                <div v-if="suggestedMembers.length === 0" class="mb-2">
                    Aanmaak nieuw lid:
                </div>
                <div v-else-if="suggestedMembers.length === 1" class="mb-2">
                    <member-badge :member="suggestedMembers[0]"/>
                </div>
                <div v-else class="flex gap-2 mb-2">
                    <div>Koppel deze inschrijving aan:</div>
                    <div class="flex-grow">
                        <Dropdown v-model="command.memberId"
                                  :options="suggestedMembersList"
                                  optionLabel="label"
                                  optionValue="value"
                                  placeholder="Selecteer lid"
                                  class="w-full p-inputtext-sm"/>
                    </div>
                </div>

                <!-- -- member ------------------------------------------------------------------------------------- -->
                <div class="bg-slate-200 rounded-t-lg px-4 py-2">
                    <div class="flex flex-row">
                        <div class="basis-1/2">
                            <div class="mb-1 font-bold">Voornaam *</div>
                            <span class="p-input-icon-right w-full">
                                <InputText
                                    placeholder="voornaam"
                                    class="w-full p-inputtext-sm" v-model="command.firstname"/>
                                <i v-if="!new$.firstname.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="new$.firstname.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                        <div class="basis-1/2 ml-4">
                            <div class="mb-1 font-bold">Naam *</div>
                            <span class="p-input-icon-right w-full">
                                <InputText
                                    placeholder="achternaam"
                                    class="w-full p-inputtext-sm" v-model="command.lastname"/>
                                <i v-if="!new$.lastname.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="new$.lastname.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                    </div>

                    <!-- -- email ---------------------------------------------------------------------------------- -->
                    <div class="flex flex-row mt-4 mb-2">
                        <div class="basis-1/3 text-right text-xs mr-4 font-bold">
                            Email *
                        </div>
                        <div class="basis-2/3 ml-2">
                            <span class="p-input-icon-right w-full">
                                <InputText
                                    placeholder="email"
                                    class="w-full p-inputtext-sm" v-model="command.email"/>
                                <i v-if="!new$.email.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="new$.email.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                    </div>

                    <!-- -- rijksregisternummer -------------------------------------------------------------------- -->
                    <div class="flex flex-row mt-6">
                        <div class="basis-1/3 text-right text-xs font-bold mr-4">
                            Geboorte datum *
                        </div>
                        <div class="basis-2/3 flex gap-2 ml-2">
                            <div class="text-sm">
                                <span>&nbsp;&nbsp;&nbsp;</span>
                                <span>
                                    <RadioButton name="gender" value="M" v-model="command.gender" input-id="M"/>
                                    <label for="M" class="text-sm"> M </label>
                                </span>
                                <span class="ml-2">
                                    <RadioButton name="gender" value="V" v-model="command.gender" input-id="V"/>
                                    <label for="V" class="text-sm"> V </label>
                                </span>
                                <span class="ml-2">
                                    <RadioButton name="gender" value="X" v-model="command.gender" input-id="X"/>
                                    <label for="X" class="text-sm"> X </label>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row mt-6 mb-2">
                        <div class="basis-1/3 text-right text-xs mr-4 font-bold">
                            Geboortedatum *
                        </div>
                        <div class="basis-1/5 ml-1">
                            <span class="p-input-icon-right w-3/4">
                                <InputText
                                    placeholder="dd"
                                    class="w-full p-inputtext-sm"
                                    v-model="command.dateOfBirthDD"/>
                                <i v-if="!new$.dateOfBirthDD.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="new$.dateOfBirthDD.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                            /
                        </div>
                        <div class="basis-1/5 ml-4">
                            <span class="p-input-icon-right w-3/4">
                                <InputText
                                    placeholder="mm"
                                    class="w-full p-inputtext-sm" v-model="command.dateOfBirthMM"/>
                                <i v-if="!new$.dateOfBirthMM.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="new$.dateOfBirthMM.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                            /
                        </div>
                        <div class="basis-1/5 ml-4">
                            <span class="p-input-icon-right w-full">
                                <InputText
                                    placeholder="yyyy"
                                    class="w-full p-inputtext-sm" v-model="command.dateOfBirthYYYY"/>
                                <i v-if="!new$.dateOfBirthYYYY.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="new$.dateOfBirthYYYY.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- -- contact------------------------------------------------------------------------------------- -->
                <div class="bg-orange-100 rounded-b-lg px-4 py-4">
                    <div class="text-xl">Adres</div>
                    <div class="flex flex-row">
                        <div class="basis-3/5">
                            <div class="mb-1"><label class="text-xs">Straat *</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="command.addressStreet"/>
                                <i v-if="!new$.addressStreet.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="new$.addressStreet.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                        <div class="basis-1/5 ml-2">
                            <div class="mb-1"><label class="text-xs">Nummer *</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="command.addressNumber"/>
                                <i v-if="!new$.addressNumber.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="new$.addressNumber.$invalid" class="pi pi-times text-red-600"/>
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
                                <i v-if="!new$.addressZip.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="new$.addressZip.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                        <div class="basis-3/4 ml-2">
                            <div class="mb-1"><label class="text-xs">Gemeente *</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="command.addressCity"/>
                                <i v-if="!new$.addressCity.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="new$.addressCity.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                    </div>

                    <div class="text-xl mt-4">Contact (ouders)</div>
                    <div class="flex flex-row mt-1">
                        <div class="basis-1/2">
                            <div class="mb-1"><label class="text-xs">Contact Naam *</label></div>
                            <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.contactLastname"/>
                            <i v-if="!new$.contactLastname.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="new$.contactLastname.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                        </div>
                        <div class="basis-1/2 ml-2">
                            <div class="mb-1"><label class="text-xs">Voornaam *</label></div>
                            <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.contactFirstname"/>
                            <i v-if="!new$.contactFirstname.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="new$.contactFirstname.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                        </div>
                    </div>
                    <div class="flex flex-row mt-1">
                        <div class="basis-1/2">
                            <div class="mb-1"><label class="text-xs">Contact email *</label></div>
                            <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.contactEmail"/>
                            <i v-if="!new$.contactEmail.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="new$.contactEmail.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                        </div>
                        <div class="basis-1/2 ml-2">
                            <div class="mb-1"><label class="text-xs">Telefoon</label></div>
                            <InputText class="w-full p-inputtext-sm" v-model="command.contactPhone"/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="basis-1/2 ml-4">

                <!-- -- location ----------------------------------------------------------------------------------- -->
                <div class="flex flex-row">
                    <div class="basis-1/5 text-right">
                        <strong>Locatie</strong>
                    </div>
                    <div class="basis-2/5 ml-4">
                        <div v-if="appStore.configuration">
                            <div v-for="location in appStore.configuration.locations" class="mr-4 mt-1">
                                <RadioButton name="location" :value="location.id"
                                             v-model="command.locationId"
                                             :input-id="location.name"/>
                                <label :for="location.name" class="ml-2"> {{ location.name }} </label>
                            </div>
                        </div>
                    </div>
                    <div class="basis-2/5 ml-4">
                        <div class="basis-1/4">
                            <strong>Aantal trainingen</strong>
                        </div>
                        <div class="basis-1/4 mt-2">
                            <div>
                                <RadioButton name="numberOfTraining" :value="1"
                                             v-model="command.numberOfTraining"
                                             input-id="1times"/>
                                <label for="1times"> 1 keer per week </label>
                            </div>
                            <div class="mt-1">
                                <RadioButton name="numberOfTraining" :value="2"
                                             v-model="command.numberOfTraining"
                                             input-id="2times"/>
                                <label for="2times"> 2 keer per week </label>
                            </div>
                            <div class="mt-1">
                                <RadioButton name="numberOfTraining" :value="3"
                                             v-model="command.numberOfTraining"
                                             input-id="3times"/>
                                <label for="3times"> 3 tot 5 keer per week </label>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- -- federation --------------------------------------------------------------------------------- -->
                <div class="flex flex-row border-t-[1px] border-b-[1px] border-gray-400 my-8 py-4">
                    <div class="basis-1/4 text-right">
                        Type vergunning *
                    </div>
                    <div class="basis-3/4 ml-4">
                        <div v-if="appStore.configuration">
                            <span v-for="federation in appStore.configuration.federations" class="mr-4">
                                <RadioButton name="federation" :value="federation.id"
                                             v-model="command.federationId"
                                             :input-id="federation.name"/>
                                <label :for="federation.name" class="ml-2"> {{ federation.name.toUpperCase() }} </label>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- -- timing ------------------------------------------------------------------------------------- -->
                <div class="flex flex-row">
                    <div class="basis-1/2 text-center">
                        <SelectButton class="p-button-sm"
                                      v-model="command.memberSubscriptionIsHalfYear"
                                      :options="selectButtonOptions"
                                      option-value="value"
                                      optionLabel="name"
                                      aria-labelledby="basic"
                        />
                    </div>
                    <div class="basis-1/2">
                        <div class="flex gap-2">
                            <div class="mt-1">
                                Vanaf
                            </div>
                            <div>
                                <span class="p-input-icon-right w-full">
                                    <InputText
                                        v-model="command.memberSubscriptionStartMM"
                                        class="p-inputtext-sm w-16"></InputText>
                                    <i v-if="!new$.memberSubscriptionStartMM.$invalid"
                                       class="pi pi-check text-green-600"/>
                                    <i v-if="new$.memberSubscriptionStartMM.$invalid"
                                       class="pi pi-times text-red-600"/>
                                </span>
                            </div>
                            <div>
                                /
                            </div>
                            <div>
                                <span class="p-input-icon-right w-full">
                                    <InputText
                                        v-model="command.memberSubscriptionStartYY"
                                        class="p-inputtext-sm w-24"></InputText>
                                    <i v-if="!new$.memberSubscriptionStartYY.$invalid"
                                       class="pi pi-check text-green-600"/>
                                    <i v-if="new$.memberSubscriptionStartYY.$invalid"
                                       class="pi pi-times text-red-600"/>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- -- timing calculation ------------------------------------------------------------------------- -->
                <div class="flex flex-row mt-4">
                    <div class="basis-1/2 text-center">
                        Lid van {{ memberSubscriptionStartMM }}/ {{ memberSubscriptionStartYY }}
                        tot <strong>{{ memberSubscriptionEndMM }} / {{ memberSubscriptionEndYY }}</strong>
                    </div>
                    <div class="basis-1/2 text-center">
                        Vergunning van
                        {{ licenseStartMM }} / {{ licenseStartYY }}
                        tot <strong>{{ licenseEndMM }} / {{ licenseEndYY }}</strong>
                    </div>
                </div>

                <!-- berekening ---------------------------------------------------------------------------------------- -->
                <div class="flex flex-row mt-3 bg-gray-500 py-1 px-4 text-white">
                    <div class="basis-1/4 flex">
                        <div class="mr-2">
                            Gezinskorting?
                        </div>
                        <div class="mt-1">
                            <InputSwitch v-model="command.isReductionFamily"/>
                        </div>
                    </div>
                    <div class="basis-1/6 text-right mr-4 text-xs mt-1">
                        Totaal:
                    </div>
                    <div class="basis-3/6">
                        {{ command.memberSubscriptionTotal }} €
                    </div>
                    <div class="basis-1/6">
                        + {{ command.licenseTotal }} €
                    </div>
                    <div class="basis-1/6 font-bold text-right">
                        = {{ totalAmount }} €
                    </div>
                </div>

                <!-- -- opmerkingen--------------------------------------------------------------------------------- -->
                <div class="flex flex-row mt-3 border-t-[1px] border-gray-400 pt-2">
                    <div class="basis-1/4 text-right mr-4 text-xs text-gray-600">
                        Opmerkingen
                    </div>
                    <div class="basis-3/4">
                        <Textarea v-model="command.remarks" :autoResize="true" rows="6" cols="30" class="w-full"/>
                    </div>
                </div>
                <div class="mt-4">
                    <Button
                        @click="currentStep=2"
                        :disabled="!(formIsValid)"
                        icon="pi pi-chevron-circle-right"
                        label="Volgende" class="p-button-success w-full"/>
                </div>

            </div>
        </div>

        <!-- ------------------------------------------------------------------------------------------------------- -->
        <!-- STEP 2 : Overview                                                                                       -->
        <!-- ------------------------------------------------------------------------------------------------------- -->
        <div v-if="(currentStep===2)">
            <!-- back button -->
            <div>
                <Button
                    @click="currentStep=1"
                    icon="pi pi-chevron-circle-left"
                    label="Wijzig inschrijving" class="p-button-sm p-button-secondary"/>
            </div>
            <!-- subscription overview -->
            <review-new-member-form-overview :command="command"/>
            <!-- submit button -->
            <div class="mt-2">
                <Button v-if="isSaving"
                        disabled
                        icon="pi pi-spin pi-spinner"
                        label="Inschrijven & bericht verzenden"
                        class="p-button-success w-full"/>
                <Button v-else
                        @click="sendMemberSubscription"
                        icon="pi pi-send"
                        label="Inschrijven & bericht verzenden"
                        class="p-button-success w-full"/>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {computed, onMounted, ref} from "vue";
import {email, maxValue, minValue, numeric, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {vMaska} from "maska";
import moment from "moment/moment";
import {useMemberStore} from "@/store/member";
import {useToast} from "primevue/usetoast";
import {SubscriptionTypeEnum} from "@/api/query/enum";
import ReviewNewMemberFormOverview from "@/components/subscription/reviewNewMember/reviewNewMemberFormOverview.vue";
import {type MemberSuggestModel, suggestMember} from "@/api/query/suggestMember";
import MemberBadge from "@/components/member/memberBadge.vue";
import {newMemberWebSubscription} from "@/api/command/subscription/newMemberWebSubscription";

const emit = defineEmits(["submitted"]);
const appStore = useAppStore();
const memberStore = useMemberStore();
const currentStep = ref<number>(1);
const selectButtonOptions = ref([
    {name: 'Half-jaarlijks', value: true},
    {name: 'Jaarlijks', value: false}
]);

// -- suggest members -------------------------------------------------------------------------------------------------

const suggestedMembers = ref([]);

const suggestedMembersCommand = ref<MemberSuggestModel>({
    firstname: memberStore.subscriptionDetail.firstname,
    lastname: memberStore.subscriptionDetail.lastname,
    dateOfBirth: memberStore.subscriptionDetail.dateOfBirth,
});

async function suggestMembers() {
    suggestedMembers.value = await suggestMember(suggestedMembersCommand.value);
    if (suggestedMembers.value.length === 1) {
        command.value.memberId = suggestedMembers.value[0].id;
    }
}

onMounted(() => {
    void suggestMembers();
});

const suggestedMembersList = computed(() => {
    let _result = [];
    _result.push({
        label: "Nieuw lid",
        value: 0
    });
    for (let i = 0; i < suggestedMembers.value.length; i++) {
        _result.push({
            label: suggestedMembers.value[i].firstname + " " + suggestedMembers.value[i].lastname + " (YK-" + suggestedMembers.value[i].id + ")",
            value: suggestedMembers.value[i].id
        });
    }
    return _result;
});

// -- command ----------------------------------------------------------------------------------------------------------

const command = ref<NewMemberWebSubscriptionCommand>({
    subscriptionId: memberStore.subscriptionDetail.id,
    memberId: 0,

    type: SubscriptionTypeEnum.NEW_SUBSCRIPTION,
    federationId: memberStore.subscriptionDetail.federation.id,
    locationId: memberStore.subscriptionDetail.location.id,
    firstname: memberStore.subscriptionDetail.firstname,
    lastname: memberStore.subscriptionDetail.lastname,
    email: memberStore.subscriptionDetail.contactEmail,
    nationalRegisterNumber: memberStore.subscriptionDetail.nationalRegisterNumber,
    dateOfBirthDD: moment(memberStore.subscriptionDetail.dateOfBirth).format("DD"),
    dateOfBirthMM: moment(memberStore.subscriptionDetail.dateOfBirth).format("MM"),
    dateOfBirthYYYY: moment(memberStore.subscriptionDetail.dateOfBirth).format("YYYY"),
    dateOfBirth: memberStore.subscriptionDetail.dateOfBirth,
    gender: memberStore.subscriptionDetail.gender,
    contactFirstname: memberStore.subscriptionDetail.contactFirstname,
    contactLastname: memberStore.subscriptionDetail.contactLastname,
    contactEmail: memberStore.subscriptionDetail.contactEmail,
    contactPhone: memberStore.subscriptionDetail.contactPhone,
    addressStreet: memberStore.subscriptionDetail.addressStreet,
    addressNumber: memberStore.subscriptionDetail.addressNumber,
    addressBox: memberStore.subscriptionDetail.addressBox,
    addressZip: memberStore.subscriptionDetail.addressZip,
    addressCity: memberStore.subscriptionDetail.addressCity,
    memberSubscriptionStart: memberStore.subscriptionDetail.memberSubscriptionStart,
    memberSubscriptionStartMM: moment(memberStore.subscriptionDetail.memberSubscriptionStart).format("MM"),
    memberSubscriptionStartYY: moment(memberStore.subscriptionDetail.memberSubscriptionStart).format("YYYY"),
    memberSubscriptionEnd: memberStore.subscriptionDetail.memberSubscriptionEnd,
    memberSubscriptionTotal: memberStore.subscriptionDetail.memberSubscriptionTotal,
    memberSubscriptionIsPartSubscription: memberStore.subscriptionDetail.memberSubscriptionIsPartSubscription,
    memberSubscriptionIsHalfYear: memberStore.subscriptionDetail.memberSubscriptionIsHalfYear,
    memberSubscriptionIsPayed: false,
    licenseStart: memberStore.subscriptionDetail.licenseStart,
    licenseStartMM: moment(memberStore.subscriptionDetail.licenseStart).format("MM"),
    licenseStartYY: moment(memberStore.subscriptionDetail.licenseStart).format("YYYY"),
    licenseEnd: memberStore.subscriptionDetail.licenseEnd,
    licenseTotal: memberStore.subscriptionDetail.licenseTotal,
    licenseIsPartSubscription: memberStore.subscriptionDetail.licenseIsPartSubscription,
    licenseIsPayed: false,
    numberOfTraining: memberStore.subscriptionDetail.numberOfTraining,
    isExtraTraining: memberStore.subscriptionDetail.isExtraTraining,
    isReductionFamily: memberStore.subscriptionDetail.isReductionFamily,
    total: memberStore.subscriptionDetail.total,
    remarks: memberStore.subscriptionDetail.remarks,
    isJudogiBelt: memberStore.subscriptionDetail.isJudogiBelt,
});

// -- validation -------------------------------------------------------------------------------------------------------

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

const memberSubscriptionDateValidator = function (value: string) {
    if (command.value.memberSubscriptionStartYY.length !== 0
        && command.value.memberSubscriptionStartMM.length !== 0
    ) {
        try {
            command.value.memberSubscriptionStart = new Date(
                parseInt(command.value.memberSubscriptionStartYY),
                parseInt(command.value.memberSubscriptionStartMM) - 1,
                1,
                8,
                0,
                0,
                0
            );
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
    email: {required},
    dateOfBirthDD: {required, numeric, maxValueValue: maxValue(31), minValueValue: minValue(1), dateValidator},
    dateOfBirthMM: {required, numeric, maxValueValue: maxValue(12), minValueValue: minValue(1), dateValidator},
    dateOfBirthYYYY: {required, numeric, minValueValue: minValue(1900), maxValueValue: maxValue(2400), dateValidator},
    locationId: {minValueValue: minValue(1)},
    federationId: {minValueValue: minValue(1)},
    nationalRegisterNumber: {nationalRegisterNumberValidator},
    addressStreet: {required},
    addressNumber: {required},
    addressZip: {required},
    addressCity: {required},
    contactFirstname: {required},
    contactLastname: {required},
    contactEmail: {email, required},
    memberSubscriptionStartMM: {
        required,
        numeric,
        maxValueValue: maxValue(12),
        minValueValue: minValue(1),
        memberSubscriptionDateValidator
    },
    memberSubscriptionStartYY: {
        required,
        numeric,
        minValueValue: minValue(1900),
        maxValueValue: maxValue(2400),
        memberSubscriptionDateValidator
    },
};

const new$ = useVuelidate(rules, command);

const isSaving = ref<boolean>(false);
const toaster = useToast();

async function sendMemberSubscription() {
    isSaving.value = true;
    let result = await newMemberWebSubscription(command.value);
    memberStore.increaseMemberCounter();
    toaster.add({
        severity: "success",
        summary: "Nieuw lid aangemaakt, confirmatie bericht is verstuurd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    isSaving.value = false;
    emit('submitted');
}

// -- computed properties ----------------------------------------------------------------------------------------------

const memberSubscriptionStartMM = computed((): string => {
    return moment(memberSubscriptionStart.value).format("MM")
});

const memberSubscriptionStartYY = computed((): string => {
    return moment(memberSubscriptionStart.value).format("YYYY")
});

const memberSubscriptionStart = computed((): Date => {
    return new Date(
        parseInt(command.value.memberSubscriptionStartYY),
        parseInt(command.value.memberSubscriptionStartMM) - 1,
        1,
        8,
        0,
        0,
        0
    );
});

const memberSubscriptionEnd = computed((): Date => {
    let _startDate = new Date(
        parseInt(command.value.memberSubscriptionStartYY),
        parseInt(command.value.memberSubscriptionStartMM) - 1,
        1,
        8,
        0,
        0,
        0
    );
    let _startDateMoment = moment(_startDate);
    if (!command.value.memberSubscriptionIsHalfYear) {
        let _endDateMoment = _startDateMoment.add(1, 'years');
        command.value.memberSubscriptionEnd = _endDateMoment.toDate();
        return _endDateMoment.toDate();
    } else {
        let _addAmount = 5;
        let _startMonth = parseInt(command.value.memberSubscriptionStartMM);
        if (_startMonth == 2 || _startMonth == 3 || _startMonth == 4 || _startMonth == 5
            || _startMonth == 6 || _startMonth == 7 || _startMonth == 8) {
            _addAmount = 7;
        }
        let _endDateMoment = _startDateMoment.add(_addAmount, 'months');
        command.value.memberSubscriptionEnd = _endDateMoment.toDate();
        return _endDateMoment.toDate();
    }
});

const memberSubscriptionEndMM = computed((): string => {
    return moment(memberSubscriptionEnd.value).format("MM")
});

const memberSubscriptionEndYY = computed((): string => {
    return moment(memberSubscriptionEnd.value).format("YYYY")
});

const licenseStart = computed((): Date => {
    command.value.licenseStart = command.value.memberSubscriptionStart;
    return command.value.licenseStart;
});

const licenseStartMM = computed((): string => {
    return moment(licenseStart.value).format("MM")
});

const licenseStartYY = computed((): string => {
    return moment(licenseStart.value).format("YYYY")
});

const licenseEnd = computed((): Date => {
    let _startDate = new Date(
        parseInt(command.value.memberSubscriptionStartYY),
        parseInt(command.value.memberSubscriptionStartMM) - 1,
        1,
        8,
        0,
        0,
        0
    );
    let _startDateMoment = moment(_startDate);
    let _endDateMoment = _startDateMoment.add(1, 'years');
    command.value.licenseEnd = _endDateMoment.toDate();
    return _endDateMoment.toDate();
});

const licenseEndMM = computed((): string => {
    return moment(licenseEnd.value).format("MM")
});

const licenseEndYY = computed((): string => {
    return moment(licenseEnd.value).format("YYYY")
});

const totalAmount = computed((): number => {
    let _totalMemberSubscription = 0;
    let _totalLicense = 0;
    if (appStore.configuration?.settings && appStore.configuration?.federations) {
        if (command.value.numberOfTraining === 1) {
            if (command.value.memberSubscriptionIsHalfYear) {
                _totalMemberSubscription = parseFloat(appStore.configuration.settings.halfYearlyFee1Training);
            } else {
                _totalMemberSubscription = parseFloat(appStore.configuration.settings.yearlyFee1Training);
            }
        } else if (command.value.numberOfTraining === 2) {
            if (command.value.memberSubscriptionIsHalfYear) {
                _totalMemberSubscription = parseFloat(appStore.configuration.settings.halfYearlyFee2Training);
            } else {
                _totalMemberSubscription = parseFloat(appStore.configuration.settings.yearlyFee2Training);
            }
        } else {
            command.value.memberSubscriptionIsHalfYear = false;
            _totalMemberSubscription = parseFloat(appStore.configuration.settings.yearlyFee2Training);
            _totalMemberSubscription += parseFloat(appStore.configuration.settings.extraTrainingFee);
        }

        if (command.value.isReductionFamily) {
            let _reduction = _totalMemberSubscription * (parseFloat(appStore.configuration.settings.familyDiscount) / 100);
            _totalMemberSubscription -= _reduction;
        }
        if (command.value.isNewMember) {
            _totalMemberSubscription += parseFloat(appStore.configuration.settings.newMemberSubscriptionFee);
        }

        for (const federation of appStore.configuration.federations) {
            if (federation.id === command.value.federationId) {
                _totalLicense = federation.yearlySubscriptionFee;
                break;
            }
        }
    }
    command.value.memberSubscriptionTotal = Math.ceil(_totalMemberSubscription);
    command.value.licenseTotal = _totalLicense;
    command.value.total = Math.ceil(_totalMemberSubscription) + _totalLicense;
    return Math.ceil(_totalMemberSubscription) + _totalLicense;
});

const formIsValid = computed((): boolean => {
    if (new$.value.$invalid) return false;
    if (command.value.total === 0) return false;
    return true;
});

</script>

<style scoped>

</style>
