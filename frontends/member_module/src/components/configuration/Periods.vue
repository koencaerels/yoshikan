<template>
    <div class="p-4">
        <table class="w-full text-sm">
            <thead>
            <tr class="border-b-[1px]">
                <th width="5%">&nbsp;</th>
                <th width="20%">Code</th>
                <th width="20%">Naam</th>
                <th width="20%">Start Datum</th>
                <th width="20%">Eind Datum</th>
                <th width="10%">Actief</th>
                <th width="10%">&nbsp;</th>
            </tr>
            </thead>
            <Draggable v-if="appStore.configuration"
                       v-model="appStore.configuration.periods"
                       tag="tbody"
                       item-key="name"
                       handle=".handle"
                       @end="savePeriodOrder"
                       ghost-class="ghost">
                <template #item="{ element }">
                    <edit-period :item="element"/>
                </template>
            </Draggable>
            <add-period/>
        </table>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import Draggable from "vuedraggable";
import {computed, ref} from "vue";
import {useToast} from "primevue/usetoast";
import type {OrderGroupCommand} from "@/api/command/orderGroup";
import EditPeriod from "@/components/configuration/editPeriod.vue";
import AddPeriod from "@/components/configuration/addPeriod.vue";
import {orderPeriod} from "@/api/command/orderPeriod";

const appStore = useAppStore();
const toaster = useToast();
const dragging = ref<boolean>(false);

const sequence = computed((): OrderGroupCommand => {
    if (appStore.configuration) {
        let sequence = [];
        for (let i = 0; i < appStore.configuration.periods.length; i++) {
            sequence.push(appStore.configuration.periods[i].id);
        }
        return {sequence: sequence};
    } else {
        return {sequence: []};
    }
});

async function savePeriodOrder() {
    await orderPeriod(sequence.value);
    toaster.add({
        severity: "success",
        summary: "Volgorde periodes gewijzigd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    await appStore.loadConfiguration();
}

</script>
