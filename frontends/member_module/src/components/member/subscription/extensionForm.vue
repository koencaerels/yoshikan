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
    <div style="width:1000px;">

        <!-- ------------------------------------------------------------------------------------------------------- -->
        <!-- STEP 1                                                                                                  -->
        <!-- ------------------------------------------------------------------------------------------------------- -->

        <div v-if="(currentStep===1)">
            <!-- lid ---------------------------------------------------------------------------------- -->
            <div class="flex flex-row bg-slate-600 p-2 text-white">
                <div class="basis-1/6 ">&nbsp;</div>
                <div class="basis-5/6">
                    <div class="flex gap-4">
                        <div
                            class="text-center rounded-full bg-blue-100 text-black px-2 font-bold text-xs w-[5rem] h-[1rem] mr-2 mt-1">
                            YK-{{ command.memberId }}
                        </div>
                        <div class="text-base font-bold">
                            <span class="uppercase">{{ command.lastname }}</span>
                            {{ command.firstname }}
                        </div>
                        <div class="text-xs mt-1">
                            ° {{ moment(command.dateOfBirth).format("DD/MM/YYYY") }}
                            - {{ command.gender }}
                        </div>
                        <div>
                            &mdash; {{ props.member.location.name }}
                        </div>
                        <div>
                            &mdash; {{ props.member.federation.name }}
                        </div>
                        <div>
                            &mdash; {{ props.member.numberOfTraining }} training(en)
                        </div>
                    </div>
                </div>
            </div>

            <!-- contact form ---------------------------------------------------------------------------------- -->
            <div class="flex flex-row mt-2">
                <div class="basis-1/6 text-right mr-4 text-xs text-gray-600">
                    Contact
                </div>
                <div class="basis-5/6">
                    <div class="flex flex-row">
                        <div class="basis-1/2">
                            <div class="mb-1"><label class="text-xs">Naam *</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="command.contactLastname"/>
                                <i v-if="!extend$.contactLastname.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="extend$.contactLastname.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                        <div class="basis-1/2 ml-4">
                            <div class="mb-1"><label class="text-xs">Voornaam *</label></div>
                            <span class="p-input-icon-right w-full">
                                <InputText class="w-full p-inputtext-sm" v-model="command.contactFirstname"/>
                                <i v-if="!extend$.contactFirstname.$invalid" class="pi pi-check text-green-600"/>
                                <i v-if="extend$.contactFirstname.$invalid" class="pi pi-times text-red-600"/>
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-row mt-1">
                        <div class="basis-1/2">
                            <div class="mb-1"><label class="text-xs">Email *</label></div>
                            <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.contactEmail"/>
                            <i v-if="!extend$.contactEmail.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="extend$.contactEmail.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                        </div>
                        <div class="basis-1/2 ml-4">
                            <div class="mb-1"><label class="text-xs">Telefoon</label></div>
                            <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.contactPhone"/>
                        </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- aantal trainingen ---------------------------------------------------------------------------------- -->
            <hr class="mt-3">
            <div class="flex flex-row mt-3">
                <div class="basis-1/6 text-right mr-4 text-xs text-gray-600">
                    Aantal trainingen
                </div>
                <div class="basis-5/6">
                 <span>
                    <RadioButton name="numberOfTraining" :value="1" v-model="command.numberOfTraining"
                                 :disabled="!(command.memberSubscriptionIsPartSubscription)"
                                 input-id="1times"/>
                        <label for="1times"> 1 keer per week </label>
                </span>
                    <span class="ml-2">
                    <RadioButton name="numberOfTraining" :value="2" v-model="command.numberOfTraining"
                                 :disabled="!(command.memberSubscriptionIsPartSubscription)"
                                 input-id="2times"/>
                    <label for="2times"> 2 keer per week </label>
                </span>
                    <span class="ml-2">
                    <RadioButton name="numberOfTraining" :value="3" v-model="command.numberOfTraining"
                                 :disabled="!(command.memberSubscriptionIsPartSubscription)"
                                 input-id="3times"/>
                    <label for="3times"> 3 tot 5 keer per week </label>
                </span>
                </div>
            </div>

            <!-- federatie ---------------------------------------------------------------------------------- -->
            <hr class="mt-3">
            <div class="flex flex-row mt-3">
                <div class="basis-1/6 text-right mr-4 text-xs text-gray-600">
                    &nbsp;
                </div>
                <div class="basis-5/6">
                    <div class="flex flex-row">
                        <div class="basis-1/2 font-bold">Lidgeld</div>
                        <div class="basis-1/2 font-bold">Vergunning</div>
                    </div>
                </div>
            </div>

            <div class="flex flex-row mt-3">
                <div class="basis-1/6 text-right mr-4 text-xs text-gray-600">&nbsp;</div>
                <div class="basis-5/6">
                    <div class="flex flex-row">
                        <div class="basis-1/4">
                            <div v-if="props.member.memberSubscriptionIsHalfYear">
                                Half-jaarlijks
                            </div>
                            <div v-else>
                                Jaarlijks
                            </div>
                        </div>
                        <div class="basis-1/4 flex">
                            <div class="mr-2">
                                Gezinskorting?
                            </div>
                            <div class="mt-1.5">
                                <InputSwitch
                                    v-model="command.isReductionFamily"
                                    :disabled="!(command.memberSubscriptionIsPartSubscription)"/>
                            </div>
                        </div>
                        <div class="basis-1/2">
                            <div v-if="appStore.configuration">
                                <span v-for="federation in appStore.configuration.federations" class="mr-4">
                                    <RadioButton name="federation" :value="federation.id"
                                                 :disabled="!(command.licenseIsPartSubscription)"
                                                 v-model="command.federationId"
                                                 :input-id="federation.name"/>
                                    <label :for="federation.name" class="ml-2"> {{ federation.name }} </label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- dates ---------------------------------------------------------------------------------- -->
            <div class="flex flex-row mt-3">
                <div class="basis-1/6 text-right mr-4 text-xs text-gray-600">
                    Periodes
                </div>
                <div class="basis-5/6">
                    <div class="flex flex-row gap-2">
                        <div class="basis-1/6">
                            <div class="text-center p-2 flex" :class="memberStatusColor(props.member)">
                                van &nbsp;&nbsp; {{ moment(props.member.memberSubscriptionStart).format("MM / YYYY") }}
                            </div>
                        </div>
                        <div class="basis-1/6">
                            <div class="text-center font-bold p-2" :class="memberStatusColor(props.member)">
                                tot &nbsp;&nbsp; {{ moment(props.member.memberSubscriptionEnd).format("MM / YYYY") }}
                            </div>
                        </div>
                        <div class="basis-1/6">
                            <div v-if="showMemberSubscriptionExtendButton(props.member)" class="h-10"
                                 :class="memberStatusColor(props.member)">
                                <InputSwitch v-model="command.memberSubscriptionIsPartSubscription"
                                             class="mt-2.5 ml-4"/>
                            </div>
                        </div>
                        <div class="basis-1/6">
                            <div class="text-center p-2 flex" :class="licenseStatusColor(props.member)">
                                van &nbsp;&nbsp; {{ moment(props.member.licenseStart).format("MM / YYYY") }}
                            </div>
                        </div>
                        <div class="basis-1/6">
                            <div class="text-center font-bold p-2" :class="licenseStatusColor(props.member)">
                                tot &nbsp;&nbsp; {{ moment(props.member.licenseEnd).format("MM / YYYY") }}
                            </div>
                        </div>
                        <div class="basis-1/6">
                            <div v-if="showLicenseExtendButton(props.member)" class="h-10"
                                 :class="licenseStatusColor(props.member)">
                                <InputSwitch v-model="command.licenseIsPartSubscription" class="mt-2.5 ml-4"/>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row mt-2" v-if="command.memberSubscriptionIsPartSubscription">
                        <div class="basis-1/2">
                            <SelectButton class="p-button-sm"
                                          v-model="command.memberSubscriptionIsHalfYear"
                                          :options="selectButtonOptions"
                                          option-value="value"
                                          optionLabel="name"
                                          aria-labelledby="basic"
                            />
                        </div>
                        <div class="basis-1/2">&nbsp;</div>
                    </div>

                    <!-- period inputs ----------------------------------------------------------------------------  -->

                    <div class="flex flex-row mt-2">
                        <div class="basis-1/2">
                            <div class="flex gap-2" v-if="command.memberSubscriptionIsPartSubscription">
                                <div>
                                    <span class="p-input-icon-right w-full">
                                        <InputText
                                            v-model="command.memberSubscriptionStartMM"
                                            class="p-inputtext-sm w-16"></InputText>
                                        <i v-if="!extend$.memberSubscriptionStartMM.$invalid"
                                           class="pi pi-check text-green-600"/>
                                        <i v-if="extend$.memberSubscriptionStartMM.$invalid"
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
                                        <i v-if="!extend$.memberSubscriptionStartYY.$invalid"
                                           class="pi pi-check text-green-600"/>
                                        <i v-if="extend$.memberSubscriptionStartYY.$invalid"
                                           class="pi pi-times text-red-600"/>
                                    </span>
                                </div>
                                <div>
                                    &mdash;
                                </div>
                                <div>
                                    <InputText v-model="memberSubscriptionEndMM" class="p-inputtext-sm w-16"
                                               disabled></InputText>
                                </div>
                                <div>
                                    /
                                </div>
                                <div>
                                    <InputText v-model="memberSubscriptionEndYY" class="p-inputtext-sm w-24"
                                               disabled></InputText>
                                </div>
                            </div>
                            <div v-else class="flex gap-2 italic">
                                <div class="ml-3">van</div>
                                <div>{{ command.memberSubscriptionStartMM }}</div>
                                <div>/</div>
                                <div>{{ command.memberSubscriptionStartYY }}</div>
                                <div class="font-bold ml-6">tot</div>
                                <div class="font-bold">{{ memberSubscriptionEndMM }}</div>
                                <div class="font-bold">/</div>
                                <div class="font-bold">{{ memberSubscriptionEndYY }}</div>
                                <div><i v-if="command.memberSubscriptionIsPayed"
                                        class="pi pi-check-circle text-green-500 ml-6"></i></div>
                            </div>
                        </div>
                        <div class="basis-1/2">
                            <div class="flex gap-2" v-if="command.licenseIsPartSubscription">
                                <div>
                                    <span class="p-input-icon-right w-full">
                                        <InputText
                                            v-model="command.licenseStartMM"
                                            class="p-inputtext-sm w-16"></InputText>
                                        <i v-if="!extend$.licenseStartMM.$invalid"
                                           class="pi pi-check text-green-600"/>
                                        <i v-if="extend$.licenseStartMM.$invalid"
                                           class="pi pi-times text-red-600"/>
                                    </span>
                                </div>
                                <div>
                                    /
                                </div>
                                <div>
                                    <span class="p-input-icon-right w-full">
                                        <InputText
                                            v-model="command.licenseStartYY"
                                            class="p-inputtext-sm w-24"></InputText>
                                        <i v-if="!extend$.licenseStartYY.$invalid"
                                           class="pi pi-check text-green-600"/>
                                        <i v-if="extend$.licenseStartYY.$invalid"
                                           class="pi pi-times text-red-600"/>
                                    </span>
                                </div>
                                <div>
                                    &mdash;
                                </div>
                                <div>
                                    <InputText v-model="licenseEndMM" class="p-inputtext-sm w-16" disabled></InputText>
                                </div>
                                <div>
                                    /
                                </div>
                                <div>
                                    <InputText v-model="licenseEndYY" class="p-inputtext-sm w-24" disabled></InputText>
                                </div>
                            </div>
                            <div v-else class="flex gap-2 italic">
                                <div class="ml-3">van</div>
                                <div>{{ command.licenseStartMM }}</div>
                                <div>/</div>
                                <div>{{ command.licenseStartYY }}</div>
                                <div class="font-bold ml-6">tot</div>
                                <div class="font-bold">{{ licenseEndMM }}</div>
                                <div class="font-bold">/</div>
                                <div class="font-bold">{{ licenseEndYY }}</div>
                                <div><i v-if="command.licenseIsPayed"
                                        class="pi pi-check-circle text-green-500 ml-6"></i></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- berekening ---------------------------------------------------------------------------------------- -->
            <div class="flex flex-row mt-3 bg-gray-300 p-2">
                <div class="basis-1/6 text-right mr-4 text-xs text-gray-600">
                    Totaal
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

            <div class="flex flex-row mt-3">
                <div class="basis-1/6 text-right mr-4 text-xs text-gray-600">
                    Opmerkingen
                </div>
                <div class="basis-5/6">
                    <Textarea v-model="command.remarks" :autoResize="true" rows="3" cols="30" class="w-full"/>
                </div>
            </div>

            <div class="flex flex-row mt-3">
                <div class="basis-1/6 mr-4">&nbsp;</div>
                <div class="basis-5/6">
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
                    label="Wijzig verlenging details" class="p-button-sm p-button-secondary"/>
            </div>
            <!-- extension overview -->
            <extension-form-overview :member="props.member" :command="command"></extension-form-overview>
            <!-- submit button -->
            <div class="mt-2">
                <Button v-if="isSaving"
                        disabled
                        icon="pi pi-spin pi-spinner"
                        label="Verlengen & bericht verzenden"
                        class="p-button-success w-full"/>
                <Button v-else
                        @click="sendMemberExtension"
                        icon="pi pi-send"
                        label="Verlengen & bericht verzenden"
                        class="p-button-success w-full"/>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import type {Member} from "@/api/query/model";
import {computed, ref} from "vue";
import {email, maxValue, minValue, numeric, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import moment from "moment";
import {useAppStore} from "@/store/app";
import {memberStatusColor, showMemberSubscriptionExtendButton} from "@/functions/memberStatus";
import {licenseStatusColor, showLicenseExtendButton} from "@/functions/licenseStatus";
import type {MemberExtendSubscriptionCommand} from "@/api/command/subscription/memberExtendSubscription";
import ExtensionFormOverview from "@/components/member/subscription/extensionFormOverview.vue";
import {changeMemberDetails} from "@/api/command/changeMemberDetails";
import {useMemberStore} from "@/store/member";
import {useToast} from "primevue/usetoast";
import {memberExtendSubscription} from "@/api/command/subscription/memberExtendSubscription";
import {SubscriptionTypeEnum} from "@/api/query/enum";

const emit = defineEmits(["submitted"]);
const props = defineProps<{ member: Member, }>();
const appStore = useAppStore();
const currentStep = ref<number>(1);
const selectButtonOptions = ref([
    {name: 'Half-jaarlijks', value: true},
    {name: 'Jaarlijks', value: false}
]);

const command = ref<MemberExtendSubscriptionCommand>({
    memberId: props.member.id,
    federationId: props.member.federation.id,
    locationId: props.member.location.id,

    contactFirstname: (props.member.contactFirstname === '') ? props.member.firstname : props.member.contactFirstname,
    contactLastname: (props.member.contactLastname === '') ? props.member.lastname : props.member.contactLastname,
    contactEmail: (props.member.contactEmail === '') ? props.member.email : props.member.contactEmail,
    contactPhone: props.member.contactPhone,

    firstname: props.member.firstname,
    lastname: props.member.lastname,
    dateOfBirth: props.member.dateOfBirth,
    gender: props.member.gender,

    type: '',
    memberSubscriptionIsPartSubscription: false,
    memberSubscriptionIsHalfYear: props.member.memberSubscriptionIsHalfYear,
    memberSubscriptionStartMM: moment(props.member.memberSubscriptionEnd).format("MM"),
    memberSubscriptionStartYY: moment(props.member.memberSubscriptionEnd).format("YYYY"),
    memberSubscriptionStart: props.member.memberSubscriptionEnd,
    memberSubscriptionEnd: props.member.memberSubscriptionEnd,
    memberSubscriptionTotal: 0,
    memberSubscriptionIsPayed: true,

    licenseIsPartSubscription: false,
    licenseStartMM: moment(props.member.licenseEnd).format("MM"),
    licenseStartYY: moment(props.member.licenseEnd).format("YYYY"),
    licenseStart: props.member.licenseEnd,
    licenseEnd: props.member.licenseEnd,
    licenseTotal: 0,
    licenseIsPayed: true,

    numberOfTraining: props.member.numberOfTraining,
    isReductionFamily: false,
    isNewMember: false,
    isExtraTraining: false,

    total: 0,
    remarks: "",

    isJudogiBelt: false,
});

const isSaving = ref<boolean>(false);
const memberStore = useMemberStore();
const toaster = useToast();

async function sendMemberExtension() {
    isSaving.value = true;
    let result = await memberExtendSubscription(command.value);
    await memberStore.reloadMemberDetail();
    memberStore.increaseMemberCounter();
    toaster.add({
        severity: "success",
        summary: "Lidmaatschap en/of vergunning verlengd, email bericht is verstuurd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    isSaving.value = false;
    emit('submitted');
}

// ---------------------------------------------------------------------------------------------------------------------
// -- validation
// ---------------------------------------------------------------------------------------------------------------------

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

const licenseDateValidator = function (value: string) {
    if (command.value.licenseStartMM.length !== 0
        && command.value.licenseStartYY.length !== 0
    ) {
        try {
            command.value.licenseStart = new Date(
                parseInt(command.value.licenseStartYY),
                parseInt(command.value.licenseStartMM) - 1,
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

const rules = {
    contactFirstname: {required},
    contactLastname: {required},
    contactEmail: {required, email},
    locationId: {minValueValue: minValue(1)},
    federationId: {minValueValue: minValue(1)},
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
    licenseStartMM: {required, numeric, maxValueValue: maxValue(12), minValueValue: minValue(1), licenseDateValidator},
    licenseStartYY: {
        required,
        numeric,
        minValueValue: minValue(1900),
        maxValueValue: maxValue(2400),
        licenseDateValidator
    },
};

const extend$ = useVuelidate(rules, command);

// ---------------------------------------------------------------------------------------------------------------------
// -- computed properties
// ---------------------------------------------------------------------------------------------------------------------

const memberSubscriptionEnd = computed((): Date => {
    if (command.value.memberSubscriptionIsPartSubscription) {
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
    } else {
        return props.member.memberSubscriptionEnd;
    }
});

const memberSubscriptionEndMM = computed((): string => {
    return moment(memberSubscriptionEnd.value).format("MM")
});

const memberSubscriptionEndYY = computed((): string => {
    return moment(memberSubscriptionEnd.value).format("YYYY")
});

const licenseEnd = computed((): Date => {
    if (command.value.licenseIsPartSubscription) {
        let _startDate = new Date(
            parseInt(command.value.licenseStartYY),
            parseInt(command.value.licenseStartMM) - 1,
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
    } else {
        return props.member.licenseEnd;
    }
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

        if (command.value.memberSubscriptionIsPartSubscription) {
            command.value.type = SubscriptionTypeEnum.RENEWAL_MEMBERSHIP;
            command.value.memberSubscriptionStartMM = moment(props.member.memberSubscriptionEnd).format("MM");
            command.value.memberSubscriptionStartYY = moment(props.member.memberSubscriptionEnd).format("YYYY");
            command.value.memberSubscriptionStart = props.member.memberSubscriptionEnd;
            command.value.memberSubscriptionIsPayed = false;
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
        } else {
            command.value.memberSubscriptionStartMM = moment(props.member.memberSubscriptionStart).format("MM");
            command.value.memberSubscriptionStartYY = moment(props.member.memberSubscriptionStart).format("YYYY");
            command.value.memberSubscriptionStart = props.member.memberSubscriptionStart;
        }

        if (command.value.licenseIsPartSubscription) {
            command.value.type = SubscriptionTypeEnum.RENEWAL_LICENSE;
            command.value.licenseStartMM = moment(props.member.licenseEnd).format("MM");
            command.value.licenseStartYY = moment(props.member.licenseEnd).format("YYYY");
            command.value.licenseStart = props.member.licenseEnd;
            command.value.licenseIsPayed = false;
            for (const federation of appStore.configuration.federations) {
                if (federation.id === command.value.federationId) {
                    _totalLicense = federation.yearlySubscriptionFee;
                    break;
                }
            }
        } else {
            command.value.licenseStartMM = moment(props.member.licenseStart).format("MM");
            command.value.licenseStartYY = moment(props.member.licenseStart).format("YYYY");
            command.value.licenseStart = props.member.licenseStart;
            command.value.licenseIsPayed = !showLicenseExtendButton(props.member);
        }

        if (command.value.licenseIsPartSubscription && command.value.memberSubscriptionIsPartSubscription) {
            command.value.type = SubscriptionTypeEnum.RENEWAL_FULL;
        }
    }

    command.value.memberSubscriptionTotal = Math.ceil(_totalMemberSubscription);
    command.value.licenseTotal = _totalLicense;
    command.value.total = Math.ceil(_totalMemberSubscription) + _totalLicense;
    return Math.ceil(_totalMemberSubscription) + _totalLicense;
});

const formIsValid = computed((): boolean => {
    if (extend$.value.$invalid) return false;
    if (command.value.total === 0) return false;
    return true;
});

</script>
