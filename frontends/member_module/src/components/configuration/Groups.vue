<template>
    <div class="p-4">
        <table class="w-full text-sm">
            <thead>
            <tr class="border-b-[1px]">
                <th width="5%">&nbsp;</th>
                <th width="20%">Code</th>
                <th width="20%">Naam</th>
                <th width="20%">Min. Leeftijd</th>
                <th width="20%">Max. Leeftijd</th>
                <th width="10%">&nbsp;</th>
            </tr>
            </thead>
            <Draggable v-if="appStore.configuration"
                       v-model="appStore.configuration.groups"
                       tag="tbody"
                       item-key="name"
                       handle=".handle"
                       @end="saveGroupOrder"
                       ghost-class="ghost">
                <template #item="{ element }">
                    <edit-group :item="element"/>
                </template>
            </Draggable>
            <add-group/>
        </table>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import Draggable from "vuedraggable";
import {computed, ref} from "vue";
import {useToast} from "primevue/usetoast";
import EditGroup from "@/components/configuration/editGroup.vue";
import AddGroup from "@/components/configuration/addGroup.vue";
import type {OrderGroupCommand} from "@/api/command/orderGroup";
import {orderGroup} from "@/api/command/orderGroup";

const appStore = useAppStore();
const toaster = useToast();
const dragging = ref<boolean>(false);

const sequence = computed((): OrderGroupCommand => {
    if (appStore.configuration) {
        let sequence = [];
        for (let i = 0; i < appStore.configuration.groups.length; i++) {
            sequence.push(appStore.configuration.groups[i].id);
        }
        return {sequence: sequence};
    } else {
        return {sequence: []};
    }
});

async function saveGroupOrder() {
    await orderGroup(sequence.value);
    toaster.add({
        severity: "success",
        summary: "Volgorde groepen gewijzigd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    await appStore.loadConfiguration();
}

</script>
