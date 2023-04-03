<template>
    <div id="Federations" class="p-4">
        <table class="w-full text-sm">
            <thead>
            <tr class="border-b-[1px]">
                <th width="5%">&nbsp;</th>
                <th width="30%">Code</th>
                <th width="30%">Naam</th>
                <th width="30%">Vergunning</th>
                <th width="30%">&nbsp;</th>
            </tr>
            </thead>
            <Draggable v-if="appStore.configuration"
                       v-model="appStore.configuration.federations"
                       tag="tbody"
                       item-key="name"
                       handle=".handle"
                       @end="saveFederationOrder"
                       ghost-class="ghost">
                <template #item="{ element }">
                    <edit-federation :item="element"/>
                </template>
            </Draggable>
            <add-federation/>
        </table>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import Draggable from "vuedraggable";
import {computed, ref} from "vue";
import {useToast} from "primevue/usetoast";
import type {OrderFederationCommand} from "@/api/command/orderFederation";
import AddFederation from "@/components/configuration/addFederation.vue";
import EditFederation from "@/components/configuration/editFederation.vue";
import {orderFederation} from "@/api/command/orderFederation";

const appStore = useAppStore();
const toaster = useToast();
const dragging = ref<boolean>(false);

const sequence = computed((): OrderFederationCommand => {
    if (appStore.configuration) {
        let sequence = [];
        for (let i = 0; i < appStore.configuration.federations.length; i++) {
            sequence.push(appStore.configuration.federations[i].id);
        }
        return {sequence: sequence};
    } else {
        return {sequence: []};
    }
});

async function saveFederationOrder() {
    await orderFederation(sequence.value);
    toaster.add({
        severity: "success",
        summary: "Volgorde federaties gewijzigd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    await appStore.loadConfiguration();
}

</script>
