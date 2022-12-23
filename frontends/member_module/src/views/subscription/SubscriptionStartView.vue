<template>
    <div id="SubscriptionStartView">

        <Splitter>
            <SplitterPanel :size="50">
                <subscriptions-to-do/>
            </SplitterPanel>
            <SplitterPanel :size="50">
                subscription todo
            </SplitterPanel>
        </Splitter>

    </div>
</template>

<script setup lang="ts">

import SubscriptionsToDo from "@/components/subscription/subscriptionsToDo.vue";
</script>
