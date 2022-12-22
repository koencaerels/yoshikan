<template>
    <div class="p-4">
        <table class="w-full text-sm">
            <thead>
            <tr class="border-b-[1px]">
                <th width="5%">&nbsp;</th>
                <th width="50%">Code</th>
                <th width="50%">Naam</th>
                <th width="10%">&nbsp;</th>
            </tr>
            </thead>
            <Draggable v-if="appStore.configuration"
                       v-model="appStore.configuration.locations"
                       tag="tbody"
                       item-key="name"
                       handle=".handle"
                       @end="saveLocationOrder"
                       ghost-class="ghost">
                <template #item="{ element }">
                    <edit-location :item="element"/>
                </template>
            </Draggable>
            <add-location/>
        </table>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import Draggable from "vuedraggable";
import {computed, ref} from "vue";
import {useToast} from "primevue/usetoast";
import type {OrderGroupCommand} from "@/api/command/orderGroup";
import {orderLocation} from "@/api/command/orderLocation";
import AddLocation from "@/components/configuration/addLocation.vue";
import EditLocation from "@/components/configuration/editLocation.vue";

const appStore = useAppStore();
const toaster = useToast();
const dragging = ref<boolean>(false);

const sequence = computed((): OrderGroupCommand => {
    if (appStore.configuration) {
        let sequence = [];
        for (let i = 0; i < appStore.configuration.locations.length; i++) {
            sequence.push(appStore.configuration.locations[i].id);
        }
        return {sequence: sequence};
    } else {
        return {sequence: []};
    }
});

async function saveLocationOrder() {
    await orderLocation(sequence.value);
    toaster.add({
        severity: "success",
        summary: "Volgorde locaties gewijzigd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    await appStore.loadConfiguration();
}

</script>
