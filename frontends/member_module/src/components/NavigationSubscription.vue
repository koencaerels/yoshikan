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
            label: 'Te behandelen',
            icon: 'pi pi-file-edit',
            to: '/inschrijvingen/todo'
        },
        {
            label: 'Export',
            icon: 'pi pi-export',
            to: '/inschrijvingen/export'
        },
        {
            label: 'Archief',
            icon: 'pi pi-bars',
            to: '/inschrijvingen/archief'
        },
    ];
    return navigation;
});
</script>
