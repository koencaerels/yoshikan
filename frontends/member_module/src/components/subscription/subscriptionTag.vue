<template>
    <div id="subscriptionTag" class="text-sm">
        <div class="flex w-64 bg-green-900 rounded-full">
            <div class="text-white w-16 px-2 font-bold">
                YK-{{subscription.id}}
            </div>
            <div class="text-black bg-green-400 rounded-full w-48 px-2">
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
