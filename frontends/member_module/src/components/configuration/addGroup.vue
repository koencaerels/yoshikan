<template>
    <tr id="Component_Add_Grade"
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
            <span class="p-input-icon-right">
                <InputText class="p-inputtext-sm w-full" placeholder="code" v-model="command.code"/>
                <i v-if="!add$.code.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="add$.code.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right">
                <InputText class="p-inputtext-sm w-full" placeholder="name" v-model="command.name" />
                <i v-if="!add$.name.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="add$.name.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right">
                <InputText class="p-inputtext-sm w-full" placeholder="min.l." v-model="command.minAge" />
                <i v-if="!add$.minAge.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="add$.minAge.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right">
                <InputText class="p-inputtext-sm w-full" placeholder="max.l." v-model="command.maxAge" />
                <i v-if="!add$.maxAge.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="add$.maxAge.$invalid" class="pi pi-times text-red-600"/>
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
import {required,numeric} from "@vuelidate/validators";
import type {AddGroupCommand} from "@/api/command/addGroup";
import {addGroup} from "@/api/command/addGroup";

// -- props

const isView = ref<boolean>(true);
const isSaving = ref<boolean>(false);
const appStore = useAppStore();
const toaster = useToast();

// -- mounted

onMounted((): void => {
    add$.value.$touch();
});

const command = ref<AddGroupCommand>({
    name: '',
    code: '',
    minAge: '0',
    maxAge: '0',
});

const rules = {
    code: {required},
    name: {required},
    minAge: {required,numeric},
    maxAge: {required,numeric},
};

const add$ = useVuelidate(rules, command);

// -- functions

function editForm() {
    isView.value = false;
    command.value.code = '';
    command.value.name = '';
    command.value.minAge = '0';
    command.value.maxAge = '0';
}

function viewForm() {
    isView.value = true;
}

async function save() {
    add$.value.$touch();
    if (!add$.value.$invalid) {
        isSaving.value = true;
        isView.value = true;
        await addGroup(command.value);
        toaster.add({
            severity: "success",
            summary: "Groep toegevoegd",
            detail: "",
            life: appStore.toastLifeTime,
        });
        await appStore.loadConfiguration();
        isSaving.value = false;
    }
}

</script>
