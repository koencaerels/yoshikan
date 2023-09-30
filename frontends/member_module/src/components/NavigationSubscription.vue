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
    <div id="NavigationSubscription">
        <TabMenu :model="items"/>
    </div>
</template>

<script setup lang="ts">
import {computed} from "vue";

const items = computed(() => {
    let navigation = [
        {
            label: 'Web inschrijvingen',
            icon: 'pi pi-user',
            to: '/inschrijvingen/web'
        },
        {
            label: 'Te betalen',
            icon: 'pi pi-file-excel',
            to: '/inschrijvingen/te-betalen'
        },
        {
            label: 'Archief',
            icon: 'pi pi-bars',
            to: '/inschrijvingen/archief'
        },
        {
            label: 'Export',
            icon: 'pi pi-file-excel',
            to: '/inschrijvingen/export'
        },
    ];
    return navigation;
});
</script>
