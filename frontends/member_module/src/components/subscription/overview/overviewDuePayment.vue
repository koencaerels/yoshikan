<template>
    <overview-subscriptions-table
        :type="'duePayment'"
        :subscriptions="subscriptionsOverviewStore.subscriptionsDuePayment"/>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {useSubscriptionOverviewStore} from "@/store/subscriptionOverview";
import OverviewSubscriptionsTable from "@/components/subscription/overview/overviewSubscriptionsTable.vue";

const appStore = useAppStore();
const subscriptionsOverviewStore = useSubscriptionOverviewStore();

</script>
