<template>
    <tr id="Component_Edit_Federation"
        class="border-b-[1px]"
        v-on:keyup.enter="save"
        v-on:keyup.esc="viewForm">

        <!-- view mode ------------------------------------------------- -->
        <td v-if="isView">
            <div class="flex mt-1 mb-1 mr-2">
                <div class="mt-1 text-gray-200 hover:text-green-600 cursor-move mr-2">
                    <i class="pi pi-bars handle"></i>
                </div>
                <edit-button @click="editForm"/>
            </div>
        </td>
        <td v-if="isView">{{ item.code }}</td>
        <td v-if="isView">{{ item.name }}</td>
        <td v-if="isView">{{ item.publicLabel }}</td>
        <td v-if="isView">{{ item.yearlySubscriptionFee }} €</td>

        <!-- edit mode ------------------------------------------------- -->
        <td v-if="!isView">&nbsp;</td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right w-full">
                <InputText class="p-inputtext-sm w-full" placeholder="code" v-model="command.code"/>
                <i v-if="!edit$.code.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="edit$.code.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right w-full">
                <InputText class="p-inputtext-sm w-full" placeholder="name" v-model="command.name"/>
                <i v-if="!edit$.name.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="edit$.name.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right w-full">
                <InputText class="p-inputtext-sm w-full" placeholder="name" v-model="command.publicLabel"/>
                <i v-if="!edit$.publicLabel.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="edit$.publicLabel.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right w-full">
                <InputText class="p-inputtext-sm w-full" placeholder="code" v-model="command.yearlySubscriptionFee"/>
                <i v-if="!edit$.yearlySubscriptionFee.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="edit$.yearlySubscriptionFee.$invalid" class="pi pi-times text-red-600"/>
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
import EditButton from "@/components/common/editButton.vue";
import {useAppStore} from "@/store/app";
import {useToast} from "primevue/usetoast";
import {onMounted, ref} from "vue";
import {required, numeric} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import SaveButton from "@/components/common/saveButton.vue";
import CloseButton from "@/components/common/closeButton.vue";
import type {Federation} from "@/api/query/model";
import type {ChangeFederationCommand} from "@/api/command/changeFederation";
import {changeFederation} from "@/api/command/changeFederation";

// -- props

const props = defineProps<{
    item: Federation,
}>();

onMounted((): void => {
    edit$.value.$touch();
});

const isView = ref<boolean>(true);
const isSaving = ref<boolean>(false);
const appStore = useAppStore();
const toaster = useToast();
const command = ref<ChangeFederationCommand>({
    id: props.item.id,
    code: props.item.code,
    name: props.item.name,
    publicLabel: props.item.publicLabel,
    yearlySubscriptionFee:props.item.yearlySubscriptionFee.toString(),
});

const rules = {
    name: {required},
    code: {required},
    publicLabel: {required},
    yearlySubscriptionFee: {required,numeric}
};

const edit$ = useVuelidate(rules, command);

function editForm() {
    isView.value = false;
}

function viewForm() {
    isView.value = true;
}

async function save() {
    edit$.value.$touch();
    if (!edit$.value.$invalid) {
        isSaving.value = true;
        isView.value = true;
        await changeFederation(command.value);
        toaster.add({
            severity: "success",
            summary: "Federatie gewijzigd",
            detail: "",
            life: appStore.toastLifeTime,
        });
        await appStore.loadConfiguration();
        isSaving.value = false;
    }
}

</script>
