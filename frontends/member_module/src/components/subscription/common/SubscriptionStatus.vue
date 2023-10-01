<template>
    <div class="px-2 rounded-full text-xs text-center border-[1px]" :class="statusColor">
        {{subscription.status}}
    </div>
</template>

<script setup lang="ts">
import type {Subscription} from "@/api/query/model";
import {computed} from "vue";

const props = defineProps<{
    subscription: Subscription,
}>();

const statusColor = computed((): string => {
    let _color = 'bg-yellow-300';
    switch (props.subscription.status) {
        case 'wachtend op betaling':
            _color = 'border-orange-300';
            break;
        case 'betaald':
            _color = 'border-green-200';
            break;
        case 'afgewerkt':
            _color = 'border-green-400';
            break;
        case 'canceled':
            _color = 'border-red-300 text-white';
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
