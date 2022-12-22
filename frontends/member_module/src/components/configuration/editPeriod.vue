<template>
    <tr id="Component_Edit_Location"
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
        <td v-if="isView">{{ item.name }}</td>
        <td v-if="isView">
            <div class="px-2 bg-sky-700 rounded-full text-white text-xs font-bold w-24 text-center">{{ item.code }}</div>
        </td>
        <td v-if="isView">{{ moment(item.startDate).format("DD/MM/YYYY") }}</td>
        <td v-if="isView">{{ moment(item.endDate).format("DD/MM/YYYY") }}</td>
        <td v-if="isView"><span v-if="item.isActive"><i class="pi pi-check"></i></span></td>

        <!-- edit mode ------------------------------------------------- -->
        <td v-if="!isView" class="pl-2" colspan="2">
            <span class="p-input-icon-right w-full">
                <InputText class="p-inputtext-sm w-full" placeholder="name" v-model="command.name"/>
                <i v-if="!edit$.name.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="edit$.name.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right w-full">
                <InputText class="p-inputtext-sm w-full" placeholder="code" v-model="command.code"/>
                <i v-if="!edit$.code.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="edit$.code.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right w-full">
                <Calendar class="p-inputtext-sm w-full"
                          placeholder="start"
                          v-model="command.startDate"
                          dateFormat="dd/mm/yy"/>
                <i v-if="!edit$.startDate.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="edit$.startDate.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right w-full">
                <Calendar class="p-inputtext-sm w-full"
                          placeholder="end"
                          v-model="command.endDate"
                          dateFormat="dd/mm/yy"/>
                <i v-if="!edit$.endDate.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="edit$.endDate.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <InputSwitch v-model="command.isActive" />
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
import {required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import SaveButton from "@/components/common/saveButton.vue";
import CloseButton from "@/components/common/closeButton.vue";
import type {Period} from "@/api/query/model";
import type {ChangePeriodCommand} from "@/api/command/changePeriod";
import {changePeriod} from "@/api/command/changePeriod";
import moment from "moment";

// -- props

const props = defineProps<{
    item: Period,
}>();

onMounted((): void => {
    edit$.value.$touch();
});

const isView = ref<boolean>(true);
const isSaving = ref<boolean>(false);
const appStore = useAppStore();
const toaster = useToast();
const command = ref<ChangePeriodCommand>({
    id: props.item.id,
    code: props.item.code,
    name: props.item.name,
    startDate: new Date(props.item.startDate),
    endDate: new Date(props.item.endDate),
    isActive: props.item.isActive
});

const rules = {
    name: {required},
    code: {required},
    startDate: {required},
    endDate: {required},
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
        command.value.startDate = new Date(moment(command.value.startDate).hour(5).format());
        command.value.endDate = new Date(moment(command.value.endDate).hour(5).format());
        await changePeriod(command.value);
        toaster.add({
            severity: "success",
            summary: "Periode gewijzigd",
            detail: "",
            life: appStore.toastLifeTime,
        });
        await appStore.loadConfiguration();
        isSaving.value = false;
    }
}

</script>
