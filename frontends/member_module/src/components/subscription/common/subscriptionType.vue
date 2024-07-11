<template>
    <div class="flex gap-2">
        <div class="px-2 rounded-full text-xs text-center bg-gray-300 h-4 text-gray-900"
             v-if="subscription.memberSubscriptionIsPartSubscription">
            Lid
        </div>
        <div class="text-xs"
             v-if="subscription.memberSubscriptionIsPartSubscription && subscription.licenseIsPartSubscription"> + </div>
        <div class="px-2 rounded-full text-xs text-center bg-gray-300 h-4 text-gray-900"
             v-if="subscription.licenseIsPartSubscription">
            Vergunning
        </div>
    </div>
</template>

<script setup lang="ts">
import type {Subscription} from "@/api/query/model";

const props = defineProps<{
    subscription: Subscription,
}>();

</script>

<style scoped>

</style>
