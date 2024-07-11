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
   <overview-subscriptions-table
       :type="'new'"
       :subscriptions="subscriptionsOverviewStore.subscriptionsNew"/>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {useSubscriptionOverviewStore} from "@/store/subscriptionOverview";
import {onMounted} from "vue";
import OverviewSubscriptionsTable from "@/components/subscription/overview/overviewSubscriptionsTable.vue";

const appStore = useAppStore();
const subscriptionsOverviewStore = useSubscriptionOverviewStore();

onMounted(() => {
     void subscriptionsOverviewStore.loadSubscriptions();
});

</script>
