<template>
    <div class="px-4 py-2" v-if="memberStore.subscriptionDetail">
        <div class="flex flex-row">
            <div class="basis-1/2">
                <div>
                    <div><strong>{{ memberStore.subscriptionDetail.firstname }}
                        {{ memberStore.subscriptionDetail.lastname }}</strong></div>
                    <div>
                    <span class="text-xs">
                        (° {{ moment(memberStore.subscriptionDetail.dateOfBirth).format("DD/MM/YYYY") }}
                        - {{ memberStore.subscriptionDetail.gender }}
                        )
                    </span>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="px-2 bg-sky-400 rounded-full text-white text-xs w-32 text-center">
                        {{ memberStore.subscriptionDetail.location.name }}
                    </div>
                </div>
            </div>
            <div class="basis-1/2">
                <div class="flex">
                    <div class="w-full">
                        <Dropdown class="w-full" v-model="newStatus" :options="status"/>
                    </div>
                    <div>
                        <Button v-if="!isSaving"
                                icon="pi pi-save"
                                class="p-button-success"
                                @click="changeStatus"/>
                        <Button v-else
                                disabled
                                class="p-button-success"
                                icon="pi pi-spinner spin"/>
                    </div>
                </div>
                <div class="mt-2 pb-2">
                    <div v-if="memberStore.subscriptionDetail">
                        <div v-if="memberStore.subscriptionDetail.status === 'wachtend op betaling'">
                            <Button class="p-button-sm w-full"
                                    icon="pi pi-envelope"
                                    @click="showMailPreviewDialog"
                                    :label="buttonLabel"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- preview of the mail that is going te be send -->
    <Dialog v-model:visible="showMailPreview" v-if="memberStore.subscriptionDetail"
            :header="'Email met betalings overzicht voor YK-'+memberStore.subscriptionDetail.id"
            :modal="true">
        <subscription-payment-mail-preview v-on:send="hideMailPreviewDialog"/>
    </Dialog>

</template>

<script setup lang="ts">
import moment from "moment";
import {useMemberStore} from "@/store/member";
import {computed, ref} from "vue";
import {changeSubscriptionStatus} from "@/api/command/changeSubscriptionStatus";
import type {ChangeSubscriptionStatusCommand} from "@/api/command/changeSubscriptionStatus";
import SubscriptionPaymentMailPreview from "@/components/subscription/subscriptionPaymentMailPreview.vue";
import {useToast} from "primevue/usetoast";
import {useAppStore} from "@/store/app";

const memberStore = useMemberStore();
const newStatus = ref<string>(memberStore.subscriptionDetail?.status ?? 'nieuw');
const status = ['nieuw', 'wachtend op betaling', 'betaald', 'afgewezen'];
const isSaving = ref<boolean>(false);
const showMailPreview = ref<boolean>(false);
const toaster = useToast();
const appStore = useAppStore();

const changeSubscriptionStatusCommand = computed((): ChangeSubscriptionStatusCommand => {
    return {
        id: memberStore.subscriptionDetail?.id ?? 0,
        status: newStatus.value
    };
});

const buttonLabel = computed((): string => {
    let label = 'Verzend betalings instructies';
    if (memberStore.subscriptionDetail && memberStore.subscriptionDetail.isPaymentOverviewSend) {
        label = 'Verzend overzicht opnieuw';
    }
    return label;
});


function showMailPreviewDialog() {
    showMailPreview.value = true;
}

function hideMailPreviewDialog() {
    showMailPreview.value = false;
}

async function changeStatus() {
    isSaving.value = true;
    let result = await changeSubscriptionStatus(changeSubscriptionStatusCommand.value);
    await memberStore.reloadSubscriptionDetail(changeSubscriptionStatusCommand.value.id);
    await memberStore.loadSubscriptionTodo();
    memberStore.increaseCounter();
    toaster.add({
        severity: "success",
        summary: "Status van de inschrijving gewijzigd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    isSaving.value = false;
}

</script>
