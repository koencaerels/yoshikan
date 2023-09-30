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
    <div id="NavigationConfiguration">
        <TabMenu :model="items"/>
    </div>
</template>

<script setup lang="ts">
import {computed} from "vue";

const items = computed(() => {
    let navigation = [
        {
            label: 'Periodes',
            icon: 'pi pi-calendar',
            to: '/configuratie/periodes'
        },
        {
            label: 'Federaties',
            icon: 'pi pi-building',
            to: '/configuratie/federaties'
        },
        {
            label: 'Judogi',
            icon: 'pi pi-shopping-cart',
            to: '/configuratie/judogi'
        },
        {
            label: 'Graden',
            icon: 'pi pi-star',
            to: '/configuratie/graden'
        },
        {
            label: 'Groepen',
            icon: 'pi pi-user',
            to: '/configuratie/groepen'
        },
        {
            label: 'Locaties',
            icon: 'pi pi-map-marker',
            to: '/configuratie/locaties'
        },
        {
            label: 'Settings',
            icon: 'pi pi-wrench',
            to: '/configuratie/settings'
        },
    ];
    return navigation;
});
</script>
