<template>

    <!-- list -->
    <div id="listMemberSubscriptions">
        <div v-for="subscription in memberStore.memberSubscriptions">
            <div @click="showSubscriptionDetailFn(subscription)"
                 class="flex gap-2 text-sm border-b-[1px] border-gray-400 py-1 hover:bg-gray-200 cursor-pointer">
                <div class="flex-none w-24">
                    <subscription-badge :subscription="subscription" class="mt-0.5 ml-1"/>
                </div>
                <div class="flex-none w-44">
                    <subscription-status :subscription="subscription" class="mt-0.5"/>
                </div>
                <div class="">
                    <subscription-type :subscription="subscription" class="mt-0.5"/>
                </div>
                <div class="flex-none w-16 font-bold text-right">
                    {{ subscription.total }} €
                </div>
                <div class="grow">
                    <div class="line-clamp-1 text-xs mt-0.5">
                        <span v-if="subscription.memberSubscriptionIsPartSubscription">
                            Lid van
                            {{ moment(subscription.memberSubscriptionStart).format("MM/YYYY") }}
                            tot
                            <strong>{{ moment(subscription.memberSubscriptionEnd).format("MM/YYYY") }}</strong>
                        </span>
                        <span v-if="subscription.licenseIsPartSubscription">
                            Vergunning van
                            {{ moment(subscription.licenseStart).format("MM/YYYY") }}
                            tot
                            <strong>{{ moment(subscription.licenseEnd).format("MM/YYYY") }}</strong>
                        </span>
                    </div>
                </div>
                <div class="flex-none w-8 text-right mr-2">
                    <div class="text-xs mt-0.5" v-if="memberStore.isLoading && subscriptionToLoad === subscription.id">
                        <i class="pi pi-spin pi-spinner"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- subscription detail  -->
    <Dialog v-model:visible="showSubscriptionDetail"
            v-if="memberStore.subscriptionDetail"
            :header="'Detail van de inschrijving: YKS-'+memberStore.subscriptionDetail.id"
            :modal="true">
        <subscription-detail v-on:paid="hideSubscriptionDetailFn" v-on:canceled="hideSubscriptionDetailFn"/>
    </Dialog>

</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import {ref} from "vue";
import type {Subscription} from "@/api/query/model";
import moment from "moment";
import SubscriptionBadge from "@/components/subscription/common/SubscriptionBadge.vue";
import SubscriptionStatus from "@/components/subscription/common/SubscriptionStatus.vue";
import SubscriptionType from "@/components/subscription/common/SubscriptionType.vue";
import SubscriptionDetail from "@/components/subscription/detail/SubscriptionDetail.vue";

const memberStore = useMemberStore();
const showSubscriptionDetail = ref<boolean>(false);
const subscriptionToLoad = ref<number>(0);

async function showSubscriptionDetailFn(subscription: Subscription) {
    subscriptionToLoad.value = subscription.id;
    await memberStore.loadSubscriptionDetail(subscription.id);
    showSubscriptionDetail.value = true;
}

function hideSubscriptionDetailFn() {
    showSubscriptionDetail.value = false;
}

</script>

<style scoped>

</style>
