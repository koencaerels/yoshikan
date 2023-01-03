<template>
    <div id="subscriptionTag" class="text-xs">
        <div class="flex w-64 bg-green-900 rounded-full">
            <div class="text-white w-16 px-2 mt-0.5 pb-0.5 font-bold">
                YKS-{{subscription.id}}
            </div>
            <div class="text-black bg-green-400 rounded-full w-48 px-2 pt-0.5 font-bold">
                &gt; {{subscription.status}}
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import type {Subscription} from "@/api/query/model";

const props = defineProps<{
    subscription: Subscription,
}>();

</script>
