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
            label: 'Inschrijvingen',
            icon: 'pi pi-user-plus',
            to: '/'
        },
        {
            label: 'Leden',
            icon: 'pi pi-users',
            to: '/leden'
        },
        {
            label: 'Configuratie',
            icon: 'pi pi-cog',
            to: '/configuratie'
        },

    ];
    return navigation;
});
</script>

<style scoped>

#Navigation {

}

</style>
