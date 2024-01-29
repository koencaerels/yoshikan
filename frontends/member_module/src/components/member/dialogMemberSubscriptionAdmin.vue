<template>
    <div style="width:650px;">

        <!-- -- federation --------------------------------------------------------------------------------- -->
        <div class="flex flex-row border-t-[1px] border-gray-400 mt-4 py-4">
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

        <!-- -- membership date --------------------------------------------------------------------------- -->
        <div class="bg-blue-100 p-4">
            <div class="flex gap-4">
                <div class="mt-1 flex-grow">
                   Startdatum <strong>lidmaatschap</strong>
                </div>
                <div class="flex-none">
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
                <div class="flex-grow">
                    tot <strong>{{ memberSubscriptionEndMM }} / {{ memberSubscriptionEndYY }}</strong>
                </div>
            </div>
        </div>

        <div class="flex mt-4">
            <div class="flex-grow"></div>
            <div>
                <SelectButton class="p-button-sm"
                              v-model="command.memberShipIsHalfYear"
                              :options="selectButtonOptions"
                              option-value="value"
                              optionLabel="name"
                              aria-labelledby="basic"
                />
            </div>
            <div class="flex-grow"></div>
        </div>

        <div class="mt-4 mb-4 flex gap-4">
            <div class="flex-grow"></div>
            <div>
                <strong>Aantal trainingen</strong>
            </div>
            <div>
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
            <div class="flex-grow"></div>
        </div>

        <!-- -- license dates ------------------------------------------------------------------------- -->
        <div class="bg-blue-100 p-4">
            <div class="flex gap-4">
                <div class="mt-1 flex-grow">
                    Startdatum <strong>vergunning</strong>
                </div>
                <div class="flex-none">
                    <span class="p-input-icon-right w-full">
                        <InputText
                            v-model="command.licenseStartMM"
                            class="p-inputtext-sm w-16"></InputText>
                        <i v-if="!new$.licenseStartMM.$invalid"
                           class="pi pi-check text-green-600"/>
                        <i v-if="new$.licenseStartMM.$invalid"
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
                        <i v-if="!new$.licenseStartYY.$invalid"
                           class="pi pi-check text-green-600"/>
                        <i v-if="new$.licenseStartYY.$invalid"
                           class="pi pi-times text-red-600"/>
                    </span>
                </div>
                <div class="flex-grow">
                    tot <strong>{{ licenseEndMM }} / {{ licenseEndYY }}</strong>
                </div>
            </div>
        </div>

        <div class="mt-2">
            <Button @click="saveMemberSubscription"
                    icon="pi pi-database"
                    :loading="isSaving"
                    label="ADMIN Wijzig inschrijving"
                    class="p-button-success w-full"/>
        </div>

    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {useMemberStore} from "@/store/member";
import {computed, ref} from "vue";
import {useToast} from "primevue/usetoast";
import {maxValue, minValue, numeric, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import moment from "moment";
import {changeMemberSubscription, type ChangeMemberSubscriptionCommand} from "@/api/command/changeMemberSubscription";

const appStore = useAppStore();
const memberStore = useMemberStore();
const isSaving = ref<boolean>(false);
const emit = defineEmits(["saved"]);
const toaster = useToast();

const selectButtonOptions = ref([
    {name: 'Half-jaarlijks', value: true},
    {name: 'Jaarlijks', value: false}
]);

async function saveMemberSubscription() {
    isSaving.value = true;
    let result = await changeMemberSubscription(command.value);
    await memberStore.reloadMemberDetail();
    toaster.add({
        severity: "success",
        summary: "Inschrijving details gewijzigd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    await memberStore.reloadMemberDetail();
    isSaving.value = false;
    emit('saved');
}

const command = ref<ChangeMemberSubscriptionCommand>( {
    memberId: memberStore.memberId,
    federationId: memberStore.memberDetail?.federation.id ?? 0,

    membershipStart: memberStore.memberDetail?.memberSubscriptionStart ?? new Date(),
    membershipEnd: memberStore.memberDetail?.memberSubscriptionEnd ?? new Date(),
    memberSubscriptionStartMM: moment(memberStore.memberDetail.memberSubscriptionStart).format("MM"),
    memberSubscriptionStartYY: moment(memberStore.memberDetail.memberSubscriptionStart).format("YYYY"),
    memberShipIsHalfYear: memberStore.memberDetail.memberSubscriptionIsHalfYear,

    licenseStart: memberStore.memberDetail?.licenseStart ?? new Date(),
    licenseEnd: memberStore.memberDetail?.licenseEnd ?? new Date(),
    licenseStartMM: moment(memberStore.memberDetail.licenseStart).format("MM"),
    licenseStartYY: moment(memberStore.memberDetail.licenseStart).format("YYYY"),

    numberOfTraining: memberStore.memberDetail?.numberOfTraining ?? 1,
});

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
    if (command.value.licenseStartYY.length !== 0
        && command.value.licenseStartMM.length !== 0
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
    licenseStartMM: {
        required,
        numeric,
        maxValueValue: maxValue(12),
        minValueValue: minValue(1),
        licenseDateValidator
    },
    licenseStartYY: {
        required,
        numeric,
        minValueValue: minValue(1900),
        maxValueValue: maxValue(2400),
        licenseDateValidator
    },
};

const new$ = useVuelidate(rules, command);

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
    if (!command.value.memberShipIsHalfYear) {
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
    return new Date(
        parseInt(command.value.licenseStartYY),
        parseInt(command.value.licenseStartMM) - 1,
        1,
        8,
        0,
        0,
        0
    );
});

const licenseStartMM = computed((): string => {
    return moment(licenseStart.value).format("MM")
});

const licenseStartYY = computed((): string => {
    return moment(licenseStart.value).format("YYYY")
});

const licenseEnd = computed((): Date => {
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
});

const licenseEndMM = computed((): string => {
    return moment(licenseEnd.value).format("MM")
});

const licenseEndYY = computed((): string => {
    return moment(licenseEnd.value).format("YYYY")
});

</script>

<style scoped>

</style>
