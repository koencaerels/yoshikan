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
            to: '/inschrijvingen/nieuw'
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
