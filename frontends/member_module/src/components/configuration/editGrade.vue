<template>
    <tr id="Component_Edit_Grade"
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
        <td v-if="isView"><strong>{{ item.code }}</strong></td>
        <td v-if="isView" class="px-2">
            <div :style="'background-color: #'+item.color" class="rounded-full text-white px-2 font-bold text-center">
                {{ item.name }}
            </div>
        </td>
        <td v-if="isView">#{{ item.color }}</td>
        <td v-if="isView">&nbsp;</td>

        <!-- edit mode ------------------------------------------------- -->
        <td v-if="!isView">&nbsp;</td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right">
                <InputText class="p-inputtext-sm w-full" placeholder="code" v-model="command.code"/>
                <i v-if="!edit$.code.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="edit$.code.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <span class="p-input-icon-right">
                <InputText class="p-inputtext-sm w-full" placeholder="name" v-model="command.name"/>
                <i v-if="!edit$.name.$invalid" class="pi pi-check text-green-600"/>
                <i v-if="edit$.name.$invalid" class="pi pi-times text-red-600"/>
            </span>
        </td>
        <td v-if="!isView" class="pl-2">
            <div class="flex">
                <ColorPicker v-model="command.color"></ColorPicker>
                <div class="pl-2 mt-2 w-24">#{{ command.color }}</div>
                <div class="pl-2 mt-2">
                    <i v-if="!edit$.color.$invalid" class="pi pi-check text-green-600"/>
                    <i v-if="edit$.color.$invalid" class="pi pi-times text-red-600"/>
                </div>
            </div>
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
import type {Grade} from "@/api/query/model";
import EditButton from "@/components/common/editButton.vue";
import {useAppStore} from "@/store/app";
import {useToast} from "primevue/usetoast";
import {onMounted, ref} from "vue";
import type {ChangeGradeCommand} from "@/api/command/changeGrade";
import {required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import SaveButton from "@/components/common/saveButton.vue";
import CloseButton from "@/components/common/closeButton.vue";
import {changeGrade} from "@/api/command/changeGrade";

// -- props

const props = defineProps<{
    item: Grade,
}>();

onMounted((): void => {
    edit$.value.$touch();
});

const isView = ref<boolean>(true);
const isSaving = ref<boolean>(false);
const appStore = useAppStore();
const toaster = useToast();
const command = ref<ChangeGradeCommand>({
    id: props.item.id,
    code: props.item.code,
    name: props.item.name,
    color: props.item.color,
});

const rules = {
    name: {required},
    code: {required},
    color: {required}
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
        await changeGrade(command.value);
        toaster.add({
            severity: "success",
            summary: "Graad gewijzigd",
            detail: "",
            life: appStore.toastLifeTime,
        });
        await appStore.loadConfiguration();
        isSaving.value = false;
    }
}

</script>
