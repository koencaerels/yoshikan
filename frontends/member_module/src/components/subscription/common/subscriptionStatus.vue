<template>
    <div class="px-2 rounded-full text-xs text-center border-[1px] text-gray-900" :class="statusColor">
        {{subscription.status}}
    </div>
</template>

<script setup lang="ts">
import type {Subscription} from "@/api/query/model";
import {computed} from "vue";
import {SubscriptionStatusEnum} from "@/api/query/enum";

const props = defineProps<{
    subscription: Subscription,
}>();

const statusColor = computed((): string => {
    let _color = 'bg-yellow-300';
    switch (props.subscription.status) {
        case SubscriptionStatusEnum.AWAITING_PAYMENT:
            _color = 'border-orange-300';
            break;
        case SubscriptionStatusEnum.PAYED:
            _color = 'border-green-200';
            break;
        case SubscriptionStatusEnum.COMPLETE:
            _color = 'border-green-400';
            break;
        case SubscriptionStatusEnum.CANCELED:
            _color = 'border-red-300 text-red-400';
            break;
        default:
            _color = 'border-yellow-300';
            break;
    }
    return _color;
});

</script>

<style scoped>

</style>
