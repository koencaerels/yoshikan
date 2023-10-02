<template>
    <div style="width:900px;" v-if="memberStore.subscriptionDetail">

        <div class="flex gap-2">
            <div class="flex-none w-48 text-right text-xs text-gray-600">Status</div>
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
                Lid
            </div>
            <div v-if="memberStore.subscriptionDetail.memberId != 0">
                <div class="text-center rounded-full bg-blue-900 text-white px-2 font-bold text-xs mt-1">
                    YK-{{ memberStore.subscriptionDetail.memberId }}
                </div>
            </div>
            <div>
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
                        @click="markAsCanceled"
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
    </div>
</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import SubscriptionBadge from "@/components/subscription/common/SubscriptionBadge.vue";
import SubscriptionStatus from "@/components/subscription/common/SubscriptionStatus.vue";
import SubscriptionType from "@/components/subscription/common/SubscriptionType.vue";
import moment from "moment/moment";
import {ref} from "vue";
import {useToast} from "primevue/usetoast";
import {useAppStore} from "@/store/app";
import type {MarkSubscriptionAsPayedCommand} from "@/api/command/subscription/markSubscriptionAsPayed";
import {markSubscriptionAsPayed} from "@/api/command/subscription/markSubscriptionAsPayed";
import type {MarkSubscriptionAsCanceledCommand} from "@/api/command/subscription/markSubscriptionAsCanceled";
import {markSubscriptionAsCanceled} from "@/api/command/subscription/markSubscriptionAsCanceled";
import {SubscriptionStatusEnum} from "@/api/query/enum";

const memberStore = useMemberStore();
const isLoading = ref<boolean>(false);
const toaster = useToast();
const appStore = useAppStore();

const emit = defineEmits(["paid", "canceled"]);

const commandPay = ref<MarkSubscriptionAsPayedCommand>({
    id: memberStore.subscriptionDetail?.id ?? 0,
});

const commandCancel = ref<MarkSubscriptionAsCanceledCommand>({
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
