<template>
    <tr id="Component_Add_Judogi"
        v-on:keyup.enter="save"
        v-on:keyup.esc="viewForm">

        <!-- add button -->
        <td v-if="isView">
            <div class="flex mt-1 mb-1 mr-2 ml-4">
                <add-button @click="editForm"/>
            </div>
        </td>

        <!-- form view -->
        <td v-if="!isView">&nbsp;</td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right w-full">
                <InputText class="p-inputtext-sm w-full" placeholder="code" v-model="command.code"/>
                <i v-if="!add$.code.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="add$.code.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right w-full">
                <InputText class="p-inputtext-sm w-full" placeholder="name" v-model="command.name"/>
                <i v-if="!add$.name.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="add$.name.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right w-full">
                <InputText class="p-inputtext-sm w-full" placeholder="size" v-model="command.size"/>
                <i v-if="!add$.size.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="add$.size.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right w-full">
                <InputText class="p-inputtext-sm w-full" placeholder="price" v-model="command.price"/>
                <i v-if="!add$.price.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="add$.price.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView">
            <div class="flex mt-2 mb-2">
                <div class="mr-2 ml-2">
                    <save-button @click="save"></save-button>
                </div>
                <div>
                    <close-button @click="viewForm"></close-button>
                </div>
            </div>
        </td>
    </tr>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import {useAppStore} from "@/store/app";
import {useToast} from "primevue/usetoast";
import CloseButton from "@/components/common/closeButton.vue";
import AddButton from "@/components/common/addButton.vue";
import SaveButton from "@/components/common/saveButton.vue";
import useVuelidate from "@vuelidate/core";
import {required, numeric} from "@vuelidate/validators";
import type {AddJudogiCommand} from "@/api/command/addJudogi";
import {addJudogi} from "@/api/command/addJudogi";

// -- props

const isView = ref<boolean>(true);
const isSaving = ref<boolean>(false);
const appStore = useAppStore();
const toaster = useToast();

// -- mounted

onMounted((): void => {
    add$.value.$touch();
});

const command = ref<AddJudogiCommand>({
    name: '',
    code: '',
    size: '',
    price: '0',
});

const rules = {
    code: {required},
    name: {required},
    size: {required},
    price: {required, numeric},
};

const add$ = useVuelidate(rules, command);

// -- functions

function editForm() {
    isView.value = false;
    command.value.code = '';
    command.value.name = '';
    command.value.size = '';
    command.value.price = '0';
}

function viewForm() {
    isView.value = true;
}

async function save() {
    add$.value.$touch();
    if (!add$.value.$invalid) {
        isSaving.value = true;
        isView.value = true;
        await addJudogi(command.value);
        toaster.add({
            severity: "success",
            summary: "Judogi toegevoegd",
            detail: "",
            life: appStore.toastLifeTime,
        });
        await appStore.loadConfiguration();
        isSaving.value = false;
    }
}

</script>
