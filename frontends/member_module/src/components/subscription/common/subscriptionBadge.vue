<template>
    <div class="px-2 rounded-full text-xs font-bold text-center text-gray-900" :class="statusColor">
        YKS-{{ subscription.id }}
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
            _color = 'bg-orange-300';
            break;
        case SubscriptionStatusEnum.PAYED:
            _color = 'bg-green-200';
            break;
        case SubscriptionStatusEnum.COMPLETE:
            _color = 'bg-green-400';
            break;
        case SubscriptionStatusEnum.CANCELED:
            _color = 'bg-red-300 text-white';
            break;
        default:
            _color = 'bg-yellow-300';
            break;
    }
    return _color;
});

</script>

<style scoped>

</style>
