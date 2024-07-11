<template>
    <div class="flex gap-2">
        <div class="flex-grow text-right">
            Inschrijvingspakket
        </div>
        <div class="flex-none">
            <SelectButton class="p-button-sm"
                          v-model="model"
                          :options="selectButtonOptions"
                          option-value="value"
                          optionLabel="name"
                          aria-labelledby="basic"
            />
        </div>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {ref} from "vue";

const model = defineModel()
const appStore = useAppStore();

const selectButtonOptions = ref([
    {name: '0 €', value: 0},
    {name: '5 €', value: 5},
    {name: '10 €', value: 10}
]);

</script>

<style scoped>

</style>
