<template>
    <div class="p-4">
        <div class="flex flex-row">
            <div class="basis-1/3 mt-2">
                Jaarlijks tarief 2 trainingen
            </div>
            <div class="basis-1/6">
                <span class="p-input-icon-right">
                    <InputText class="p-inputtext-sm w-full"
                               v-model="command.yearlyFee2Training"/>
                    <i v-if="!v$.yearlyFee2Training.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="v$.yearlyFee2Training.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/12 mt-2 ml-2">€</div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Jaarlijks tarief 1 training
            </div>
            <div class="basis-1/6">
                <span class="p-input-icon-right">
                    <InputText class="p-inputtext-sm w-full"
                               v-model="command.yearlyFee1Training"/>
                    <i v-if="!v$.yearlyFee1Training.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="v$.yearlyFee1Training.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/12 mt-2 ml-2">€</div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Half-jaarlijks tarief 2 trainingen
            </div>
            <div class="basis-1/6">
                <span class="p-input-icon-right">
                    <InputText class="p-inputtext-sm w-full"
                               v-model="command.halfYearlyFee2Training"/>
                    <i v-if="!v$.halfYearlyFee2Training.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="v$.halfYearlyFee2Training.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/12 mt-2 ml-2">€</div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Half-jaarlijks tarief 1 training
            </div>
            <div class="basis-1/6">
                <span class="p-input-icon-right">
                    <InputText class="p-inputtext-sm w-full"
                               v-model="command.halfYearlyFee1Training"/>
                    <i v-if="!v$.halfYearlyFee1Training.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="v$.halfYearlyFee1Training.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/12 mt-2 ml-2">€</div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Bijdrage 3 tot 5 trainingen
            </div>
            <div class="basis-1/6">
                <span class="p-input-icon-right">
                    <InputText class="p-inputtext-sm w-full"
                               v-model="command.extraTrainingFee"/>
                    <i v-if="!v$.extraTrainingFee.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="v$.extraTrainingFee.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/12 mt-2 ml-2">€</div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Nieuw leden pakket
            </div>
            <div class="basis-1/6">
                <span class="p-input-icon-right">
                    <InputText class="p-inputtext-sm w-full"
                               v-model="command.newMemberSubscriptionFee"/>
                    <i v-if="!v$.newMemberSubscriptionFee.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="v$.newMemberSubscriptionFee.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/12 mt-2 ml-2">€</div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Korting andere gezinsleden
            </div>
            <div class="basis-1/6">
                <span class="p-input-icon-right">
                    <InputText class="p-inputtext-sm w-full"
                               v-model="command.familyDiscount"/>
                    <i v-if="!v$.familyDiscount.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="v$.familyDiscount.$invalid" class="pi pi-times text-red-600"/>
                </span>
            </div>
            <div class="basis-1/12 mt-2 ml-2">%</div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                &nbsp;
            </div>
            <div class="basis-1/6">
                <Button v-if="!isSaving"
                        label="Bewaar"
                        @click="save"
                        icon="pi pi-save"
                        class="w-full p-button-success p-button-sm"/>
                <Button v-else label="Bewaar"
                        disabled
                        class="w-full p-button-success p-button-sm"
                        icon="pi pi-spinner pi-spin"/>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {onMounted, ref} from "vue";
import type {SaveSettingsCommand} from "@/api/command/saveSettings";
import {numeric, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {useToast} from "primevue/usetoast";
import {saveSettings} from "@/api/command/saveSettings";

const appStore = useAppStore();
const isSaving = ref<boolean>(false);
const toaster = useToast();

onMounted((): void => {
    v$.value.$touch();
});

const command = ref<SaveSettingsCommand>({
    code: appStore.configuration?.settings.code ?? 'active',
    yearlyFee2Training: appStore.configuration?.settings.yearlyFee2Training ?? '0',
    yearlyFee1Training: appStore.configuration?.settings.yearlyFee1Training ?? '0',
    halfYearlyFee2Training: appStore.configuration?.settings.halfYearlyFee2Training ?? '0',
    halfYearlyFee1Training: appStore.configuration?.settings.halfYearlyFee1Training ?? '0',
    extraTrainingFee: appStore.configuration?.settings.extraTrainingFee ?? '0',
    newMemberSubscriptionFee: appStore.configuration?.settings.newMemberSubscriptionFee ?? '0',
    familyDiscount: appStore.configuration?.settings.familyDiscount ?? '0',
});

const rules = {
    yearlyFee2Training: {required, numeric},
    yearlyFee1Training: {required, numeric},
    halfYearlyFee2Training: {required, numeric},
    halfYearlyFee1Training: {required, numeric},
    extraTrainingFee: {required, numeric},
    newMemberSubscriptionFee: {required, numeric},
    familyDiscount: {required, numeric},
};

const v$ = useVuelidate(rules, command);

async function save() {
    v$.value.$touch();
    if (!v$.value.$invalid) {
        isSaving.value = true;
        await saveSettings(command.value);
        toaster.add({
            severity: "success",
            summary: "Settings gewijzigd",
            detail: "",
            life: appStore.toastLifeTime,
        });
        await appStore.loadConfiguration();
        isSaving.value = false;
    }
}

</script>
