<!--
/*
* This file is part of the Yoshi-Kan software.
*
* (c) Koen Caerels
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
-->

<template>

    <div>
        new member form
    </div>

</template>

<script setup lang="ts">
import type {Member} from "@/api/query/model";
import {useAppStore} from "@/store/app";
import {ref} from "vue";

const emit = defineEmits(["submitted"]);
const props = defineProps<{ member: Member }>();
const appStore = useAppStore();
const currentStep = ref<number>(1);
const selectButtonOptions = ref([
    {name: 'Half-jaarlijks', value: true},
    {name: 'Jaarlijks', value: false}
]);

</script>

<style scoped>

</style>
