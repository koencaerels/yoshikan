<template>
    <div id="dialogChangeGrade" style="width:400px;">

        <div>
            <Dropdown class="w-full" v-if="appStore.configuration"
                      v-model="command.grade"
                      placeholder="selecteer een graad"
                      :options="appStore.configuration.grades">
                <template #value="slotProps">
                    <div v-if="slotProps.value">
                        <div class="text-white rounded-full text-sm px-3"
                             :style="'background-color:#'+slotProps.value.color">
                            {{ slotProps.value.name }}
                        </div>
                    </div>
                    <div v-else>
                        {{ slotProps.placeholder }}
                    </div>
                </template>
                <template #option="slotProps">
                    <div class="text-white rounded-full text-sm px-3"
                         :style="'background-color:#'+slotProps.option.color">
                        {{ slotProps.option.name }}
                    </div>
                </template>
            </Dropdown>
        </div>
        <div class="mt-2">
            <Textarea auto-resize v-model="command.remark"
                      placeholder="opmerking"
                      class="w-full"></Textarea>
        </div>
        <div class="mt-4">
            <Button v-if="!isSaving"
                    label="Bewaar nieuwe graad"
                    @click="saveGrade"
                    icon="pi pi-save"
                    class="p-button-success p-button-sm w-full"/>
            <Button v-else
                    label="Bewaar nieuwe graad"
                    disabled
                    icon="pi pi-spinner pi-spin"
                    class="p-button-success p-button-sm w-full"/>
        </div>
    </div>
</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import {useAppStore} from "@/store/app";
import type {Grade} from "@/api/query/model";
import {ref} from "vue";
import type {ChangeMemberGradeCommand} from "@/api/command/changeMemberGrade";
import {useToast} from "primevue/usetoast";
import {changeMemberRemarks} from "@/api/command/changeMemberRemarks";
import {changeMemberGrade} from "@/api/command/changeMemberGrade";

const appStore = useAppStore();
const memberStore = useMemberStore();
const isSaving = ref<boolean>(false);
const emit = defineEmits(["saved"]);
const toaster = useToast();

const command = ref<ChangeMemberGradeCommand>({
    id: memberStore.memberId,
    grade: memberStore.memberDetail?.grade ?? {id: 0, code: '', color: '', name: '', uuid: ''},
    remark: ''
});

async function saveGrade() {
    isSaving.value = true;
    let result = await changeMemberGrade(command.value);
    await memberStore.reloadMemberDetail();
    memberStore.increaseMemberCounter();
    toaster.add({
        severity: "success",
        summary: "Graad gewijzigd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    isSaving.value = false;
    emit('saved');
}

</script>
