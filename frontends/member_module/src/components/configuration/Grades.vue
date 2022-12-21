<template>
    <div class="p-4">
        <table class="w-full text-sm">
            <thead>
            <tr class="border-b-[1px]">
                <th width="5%">&nbsp;</th>
                <th width="30%">Code</th>
                <th width="30%">Naam</th>
                <th width="30%">Kleur</th>
                <th width="30%">&nbsp;</th>
            </tr>
            </thead>
            <Draggable v-if="appStore.configuration"
                       v-model="appStore.configuration.grades"
                       tag="tbody"
                       item-key="name"
                       handle=".handle"
                       @end="saveGradeOrder"
                       ghost-class="ghost">
                <template #item="{ element }">
                    <edit-grade :item="element"/>
                </template>
            </Draggable>
            <add-grade/>
        </table>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import AddGrade from "@/components/configuration/addGrade.vue";
import EditGrade from "@/components/configuration/editGrade.vue";
import Draggable from "vuedraggable";
import type {OrderGradeCommand} from "@/api/command/orderGrade";
import {computed, ref} from "vue";
import {orderGrade} from "@/api/command/orderGrade";
import {useToast} from "primevue/usetoast";

const appStore = useAppStore();
const toaster = useToast();
const dragging = ref<boolean>(false);

const sequence = computed((): OrderGradeCommand => {
    if (appStore.configuration) {
        let sequence = [];
        for (let i = 0; i < appStore.configuration.grades.length; i++) {
            sequence.push(appStore.configuration.grades[i].id);
        }
        return {sequence: sequence};
    } else {
        return {sequence: []};
    }
});

async function saveGradeOrder() {
    await orderGrade(sequence.value);
    toaster.add({
        severity: "success",
        summary: "Volgorde graden gewijzigd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    await appStore.loadConfiguration();
}

</script>
