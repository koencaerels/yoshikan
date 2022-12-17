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
            label: 'Inschrijf periodes',
            icon: 'pi pi-calendar',
            to: '/configuratie/periodes'
        },
        {
            label: 'Graden',
            icon: 'pi pi-star',
            to: '/configuratie/graden'
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

<style scoped>
#NavigationConfiguration {

}
</style>
