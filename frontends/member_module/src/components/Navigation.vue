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
    <div id="Navigation">
        <TabMenu :model="items"/>
    </div>
</template>

<script setup lang="ts">
import {computed} from "vue";

const items = computed(() => {
    let navigation = [
        {
            label: 'Actieve leden',
            icon: 'pi pi-users',
            to: '/leden-overzicht'
        },
        {
            label: 'Inschrijvingen',
            icon: 'pi pi-user-plus',
            to: '/inschrijvingen/web'
        },
        {
            label: 'Archief Leden',
            icon: 'pi pi-users',
            to: '/leden'
        },
        {
            label: 'Configuratie',
            icon: 'pi pi-cog',
            to: '/configuratie/periodes'
        },
    ];
    return navigation;
});
</script>

<style scoped>

#Navigation {

}

</style>
