<template>
    <NavigationSubscription/>
    <RouterView v-slot="{ Component }">
        <KeepAlive>
            <component :is="Component"/>
        </KeepAlive>
    </RouterView>
</template>

<script setup lang="ts">
import NavigationSubscription from "@/components/NavigationSubscription.vue";
</script>
