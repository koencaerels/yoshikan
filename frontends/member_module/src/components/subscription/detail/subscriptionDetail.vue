<template>
    <div style="width:900px;" v-if="memberStore.subscriptionDetail">

        <div class="flex gap-2 border-b-[1px] border-gray-400 pb-2">

            <div class="flex-none w-48 flex gap-4">
                <div class="mt-0.5">
                    <i class="pi pi-times-circle cursor-pointer"
                       title="Sluit de inschrijving"
                       @click="emit('canceled')"></i>
                </div>
                <div class="grow">&nbsp;</div>
                <div class="flex-none">
                    <Button icon="pi pi-print cursor-pointer"
                            title="Inschrijving afdrukken" class="p-button-sm"
                            @click="printSubscription"></Button>
                </div>
                <div class="flex-none"
                    v-if="memberStore.subscriptionDetail.isPaymentOverviewSend && memberStore.subscriptionDetail.messageId">
                    <Button icon="pi pi-send cursor-pointer"
                            title="Bekijk bericht van de inschrijving"
                            class="p-button-sm"
                            @click="showMessageDetailFn(memberStore.subscriptionDetail.messageId)"></Button>
                </div>
                <div class="grow">&nbsp;</div>
            </div>
            <div class="flex-none w-24">
                <subscription-badge :subscription="memberStore.subscriptionDetail" class="mt-1"/>
            </div>
            <div class="flex-none w-48">
                <subscription-status :subscription="memberStore.subscriptionDetail" class="mt-1"/>
            </div>
            <div class="grow">
                <div class="line-clamp-1 text-xs mt-1">
                        <span v-if="memberStore.subscriptionDetail.memberSubscriptionIsPartSubscription">
                            Lid van
                            {{ moment(memberStore.subscriptionDetail.memberSubscriptionStart).format("MM/YYYY") }}
                            tot
                            <strong>{{
                                    moment(memberStore.subscriptionDetail.memberSubscriptionEnd).format("MM/YYYY")
                                }}</strong>
                        </span>
                    <span v-if="memberStore.subscriptionDetail.licenseIsPartSubscription">
                            Vergunning van
                            {{ moment(memberStore.subscriptionDetail.licenseStart).format("MM/YYYY") }}
                            tot
                            <strong>{{ moment(memberStore.subscriptionDetail.licenseEnd).format("MM/YYYY") }}</strong>
                        </span>
                </div>
            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <div class="flex-none w-48 text-right text-xs text-gray-600">
                Type
            </div>
            <div>
                <subscription-type :subscription="memberStore.subscriptionDetail"/>
            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <div class="flex-none w-48 text-right text-xs text-gray-600">
                Judoka
            </div>
            <div v-if="memberStore.subscriptionDetail.memberId">
                <div class="text-center rounded-full bg-blue-900 text-white px-2 font-bold text-xs mt-1">
                    YK-{{ memberStore.subscriptionDetail.memberId }}
                </div>
            </div>
            <div class="ml-2">
                <span class="font-bold">
                    <span class="uppercase">{{ memberStore.subscriptionDetail.lastname }}</span>
                    {{ memberStore.subscriptionDetail.firstname }}
                </span>
                <span class="text-xs ml-4">
                    ( °{{ moment(memberStore.subscriptionDetail.dateOfBirth).format("DD / MM / YYYY") }}
                    &mdash; {{ memberStore.subscriptionDetail.gender }} )
                </span>

            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <div class="flex-none w-48 text-right text-xs text-gray-600">
                Contact
            </div>
            <div class="grow">
                {{ memberStore.subscriptionDetail.contactLastname }}
                {{ memberStore.subscriptionDetail.contactFirstname }}
                <span class="text-sm">&lt;{{ memberStore.subscriptionDetail.contactEmail }}&gt;</span>
            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <div class="flex-none w-48 text-right text-xs text-gray-600">
                Locatie
            </div>
            <div>
                {{ memberStore.subscriptionDetail.location.name }} &mdash;
            </div>
            <div>
                <div v-if="memberStore.subscriptionDetail.numberOfTraining == 1">
                    1 training per week
                </div>
                <div v-if="memberStore.subscriptionDetail.numberOfTraining == 2">
                    2 trainingen per week
                </div>
                <div v-if="memberStore.subscriptionDetail.numberOfTraining == 3">
                    3 tot 5 trainingen per week
                </div>
            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <div class="flex-none w-48 text-right text-xs text-gray-600">
                Federatie
            </div>
            <div class="uppercase">
                {{ memberStore.subscriptionDetail.federation.name }}
            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <div class="flex-none w-48 text-right text-xs text-gray-600">
                Overzicht
            </div>
            <div class="grow">
                <div class="flex text-sm mb-2" v-for="item in memberStore.subscriptionDetail.subscriptionitems">
                    <div class="flex-none w-3/4 line-clamp-1">{{ item.name }}</div>
                    <div class="flex-none w-32 text-right">{{ item.price }} €</div>
                </div>
                <div class="flex text-sm mb-2 font-bold border-t-[1px] border-gray-600 pt-2">
                    <div class="flex-none w-3/4 text-right">Totaal</div>
                    <div class="flex-none w-32 text-right">{{ memberStore.subscriptionDetail.total }} €</div>
                </div>
            </div>
        </div>

        <!-- actions for websubscriptions -------------------------------------------------------------------------- -->

        <div class="flex gap-2 mt-4"
             v-if="!memberStore.subscriptionDetail.memberId
             && memberStore.subscriptionDetail.status === SubscriptionStatusEnum.NEW">

            <div class="flex-none w-48 text-right text-xs text-gray-600">
                Acties
            </div>
            <div class="grow">
                <Button @click="reviewSubscription"
                        icon="pi pi-times-circle"
                        class="p-button-success w-full"
                        label="Inschrijving confirmeren"></Button>
            </div>
            <div class="flex-none w-64">
                <Button v-if="!isLoading"
                        @click="confirmCancelSubscription($event)"
                        icon="pi pi-times-circle"
                        class="p-button-warning w-full"
                        label="Inschrijving annuleren"></Button>
                <Button v-else
                        disabled
                        icon="pi pi-spin pi-spinner"
                        class="p-button-warning w-full"
                        label="Inschrijving annuleren"></Button>
            </div>
        </div>

        <!-- actions for connected subscriptions ------------------------------------------------------------------- -->
        <div class="flex gap-2 mt-4"
             v-if="memberStore.subscriptionDetail.memberId !== 0
             && memberStore.subscriptionDetail.status === SubscriptionStatusEnum.AWAITING_PAYMENT">

            <div class="flex-none w-48 text-right text-xs text-gray-600">
                Acties
            </div>
            <div class="grow">
                <Button v-if="!isLoading"
                        @click="markAsPaid"
                        icon="pi pi-money-bill"
                        class="p-button-success w-full"
                        label="Betaling ontvangen"></Button>
                <Button v-else
                        disabled
                        icon="pi pi-spin pi-spinner"
                        class="p-button-success w-full"
                        label="Betaling ontvangen"></Button>
            </div>
            <div class="flex-none w-64">
                <Button v-if="!isLoading"
                        @click="confirmCancelSubscription($event)"
                        icon="pi pi-times-circle"
                        class="p-button-warning w-full"
                        label="Inschrijving annuleren"></Button>
                <Button v-else
                        disabled
                        icon="pi pi-spin pi-spinner"
                        class="p-button-warning w-full"
                        label="Inschrijving annuleren"></Button>
            </div>
        </div>

        <!-- actions for connected subscriptions ------------------------------------------------------------------- -->
        <div class="flex gap-2 mt-4"
             v-if="memberStore.subscriptionDetail.memberId !== 0
             && memberStore.subscriptionDetail.status === SubscriptionStatusEnum.PAYED">

            <div class="flex-none w-48 text-right text-xs text-gray-600">
                Acties
            </div>
            <div class="grow">
                <Button v-if="!isLoading"
                        @click="markAsFinished"
                        icon="pi pi-money-bill"
                        class="p-button-success w-full"
                        label="Inschrijving afwerken"></Button>
                <Button v-else
                        disabled
                        icon="pi pi-spin pi-spinner"
                        class="p-button-success w-full"
                        label="Inschrijving afwerken"></Button>
            </div>
            <div class="flex-none w-64">
                &nbsp;
            </div>
        </div>
    </div>

    <ConfirmPopup/>

    <!-- -- message detail ----------------------------------------------------------------------------------------- -->
    <Dialog v-model:visible="showMessageDetail"
            v-if="memberStore.messageDetail"
            :header="memberStore.messageDetail.subject"
            :modal="true">
        <message-detail/>
    </Dialog>

    <!-- -- review member ------------------------------------------------------------------------------------------ -->
    <Dialog v-model:visible="showReviewSubscription"
            position="topleft"
            :header="'Inschrijving confirmeren voor '+memberStore.subscriptionDetail.firstname+' '+memberStore.subscriptionDetail.lastname"
            :modal="true">
        <review-new-member-form @submitted="subscriptionReviewed"/>
    </Dialog>

</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import SubscriptionBadge from "@/components/subscription/common/subscriptionBadge.vue";
import SubscriptionStatus from "@/components/subscription/common/subscriptionStatus.vue";
import SubscriptionType from "@/components/subscription/common/subscriptionType.vue";
import moment from "moment/moment";
import {ref} from "vue";
import {useToast} from "primevue/usetoast";
import {useAppStore} from "@/store/app";
import type {MarkSubscriptionAsPayedCommand} from "@/api/command/subscription/markSubscriptionAsPayed";
import {markSubscriptionAsPayed} from "@/api/command/subscription/markSubscriptionAsPayed";
import type {MarkSubscriptionAsCanceledCommand} from "@/api/command/subscription/markSubscriptionAsCanceled";
import {markSubscriptionAsCanceled} from "@/api/command/subscription/markSubscriptionAsCanceled";
import {SubscriptionStatusEnum} from "@/api/query/enum";
import MessageDetail from "@/components/message/messageDetail.vue";
import {useConfirm} from "primevue/useconfirm";
import ReviewNewMemberForm from "@/components/subscription/reviewNewMember/reviewNewMemberForm.vue";
import {
    markSubscriptionAsFinished,
    type MarkSubscriptionAsFinishedCommand
} from "@/api/command/subscription/markSubscriptionAsFinished";

const memberStore = useMemberStore();
const isLoading = ref<boolean>(false);
const toaster = useToast();
const appStore = useAppStore();
const confirm = useConfirm();

const showMessageDetail = ref<boolean>(false);
const apiUrl = import.meta.env.VITE_API_URL as string;
const emit = defineEmits(["paid", "canceled", "subscription-reviewed", "finished"]);

// -- review subscription functions ------------------------------------------------------------------------------------

const showReviewSubscription = ref<boolean>(false);

function reviewSubscription() {
    showReviewSubscription.value = true;
}

function subscriptionReviewed() {
    showReviewSubscription.value = false;
    emit('subscription-reviewed');
}

// -- subscription detail functions ------------------------------------------------------------------------------------

async function showMessageDetailFn(messageId: number) {
    await memberStore.loadMessageDetail(messageId);
    showMessageDetail.value = true;
}

function printSubscription() {
    let url = apiUrl + '/subscriptions/print?ids=' + memberStore.subscriptionDetail.id;
    window.open(url, '_blank');
}

// -- payed function ---------------------------------------------

const commandPay = ref<MarkSubscriptionAsPayedCommand>({
    id: memberStore.subscriptionDetail?.id ?? 0,
});

async function markAsPaid() {
    if (commandPay.value.id !== 0) {
        isLoading.value = true;
        let result = await markSubscriptionAsPayed(commandPay.value);
        toaster.add({
            severity: "success",
            summary: "Betaling voor de inschrijving is geconfirmeerd.",
            detail: "",
            life: appStore.toastLifeTime,
        });
        await memberStore.reloadSubscriptionDetail();
        await memberStore.reloadMemberDetail();
        memberStore.increaseCounter();
        isLoading.value = false;
        emit('paid');
    }
}

// -- finish function ---------------------------------------------

const commandFinish = ref<MarkSubscriptionAsFinishedCommand>({
    id: memberStore.subscriptionDetail?.id ?? 0,
});

async function markAsFinished() {
    if (commandFinish.value.id !== 0) {
        isLoading.value = true;
        let result = await markSubscriptionAsFinished(commandFinish.value);
        toaster.add({
            severity: "success",
            summary: "Inschrijving is afgewerkt.",
            detail: "",
            life: appStore.toastLifeTime,
        });
        await memberStore.reloadSubscriptionDetail();
        await memberStore.reloadMemberDetail();
        memberStore.increaseCounter();
        isLoading.value = false;
        emit('finished');
    }
}

// -- cancel function ---------------------------------------------

const commandCancel = ref<MarkSubscriptionAsCanceledCommand>({
    id: memberStore.subscriptionDetail?.id ?? 0,
});

function confirmCancelSubscription(event: MouseEvent) {
    const target = event.currentTarget;
    if (target instanceof HTMLElement) {
        confirm.require({
            target: target,
            message: "Ben je zeker om deze inschrijving te annuleren ?",
            icon: "pi pi-exclamation-triangle",
            acceptLabel: "Ja",
            rejectLabel: "Nee",
            acceptIcon: "pi pi-check",
            rejectIcon: "pi pi-times",
            accept: () => {
                void markAsCanceled();
            },
            reject: () => {
                // callback to execute when user rejects the action
            },
        });
    }
}

async function markAsCanceled() {
    if (commandCancel.value.id !== 0) {
        isLoading.value = true;
        let result = await markSubscriptionAsCanceled(commandCancel.value);
        toaster.add({
            severity: "success",
            summary: "Inschrijving is geannuleerd.",
            detail: "",
            life: appStore.toastLifeTime,
        });
        await memberStore.reloadSubscriptionDetail();
        await memberStore.reloadMemberDetail();
        memberStore.increaseCounter();
        isLoading.value = false;
        emit('canceled');
    }
}

</script>

<style scoped>

</style>
