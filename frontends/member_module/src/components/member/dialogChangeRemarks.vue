<template>
    <div id="dialogChangeRemarks" style="width:600px;">
        <div>
            <simple-editor v-model="command.remarks"/>
        </div>
        <div class="flex flex-row mt-4">
            <div class="basis-1/2">&nbsp;</div>
            <div class="basis-1/2">
                <Button v-if="!isSaving"
                        label="Bewaar opmerkingen"
                        @click="saveRemarks"
                        icon="pi pi-save"
                        class="p-button-success p-button-sm w-full"/>
                <Button v-else disabled
                        label="Bewaar opmerkingen"
                        icon="pi pi-spinner pi-spin"
                        class="p-button-success p-button-sm w-full"/>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import SimpleEditor from "@/components/editor/simpleEditor.vue";
import {useMemberStore} from "@/store/member";
import {ref} from "vue";
import type {ChangeMemberRemarksCommand} from "@/api/command/changeMemberRemarks";
import {changeMemberRemarks} from "@/api/command/changeMemberRemarks";
import {useToast} from "primevue/usetoast";
import {useAppStore} from "@/store/app";

const memberStore = useMemberStore();
const appStore = useAppStore();
const command = ref<ChangeMemberRemarksCommand>({
    id: memberStore.memberId,
    remarks: memberStore.memberDetail?.remarks ?? ''
});
const isSaving = ref<boolean>(false);
const emit = defineEmits(["saved"]);
const toaster = useToast();

async function saveRemarks() {
    isSaving.value = true;
    let result = await changeMemberRemarks(command.value);
    await memberStore.reloadMemberDetail();
    toaster.add({
        severity: "success",
        summary: "Opmerkingen gewijzigd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    isSaving.value = false;
    emit('saved');
}

</script>
