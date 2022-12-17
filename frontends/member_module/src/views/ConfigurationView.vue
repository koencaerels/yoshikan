<template>
    <div id="ConfigurationView">

        <navigation-configuration/>

        <RouterView v-slot="{ Component }">
            <KeepAlive>
                <component :is="Component"/>
            </KeepAlive>
        </RouterView>

    </div>
</template>

<script setup lang="ts">
import NavigationConfiguration from "@/components/NavigationConfiguration.vue";

</script>

<style scoped>
</style>
