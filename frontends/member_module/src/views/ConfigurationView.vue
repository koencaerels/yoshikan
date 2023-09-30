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
