<template>
    <div id="memberImages" class="p-2">

        <!-- button upload -->
        <div>
            <Button @click="showDropZoneHandler"
                    v-if="!showDropZone"
                    icon="pi pi-upload"
                    label="Upload images"
                    class="p-button-sm p-button-outlined"/>
        </div>

        <!-- upload zone -->
        <member-image-drop-zone
            v-on:close="hideDropZoneHandler"
            v-if="showDropZone"/>

        <!-- list images -->
        <div v-if="memberStore.memberDetail" class="mt-2">
            <div class="grid">
                <div v-for="image in memberStore.memberDetail.images" class="memberImage ml-2 mb-2">
                    <Image :src="apiUrl+'/member/member-image/'+image.id+'/stream?t=' + timestamp"
                           :alt="image.originalName" preview/>
                    <div class="flex">
                        <!-- delete button -->
                        <div class="text-gray-400 text-xs cursor-pointer"
                             @click="confirmDeleteMemberImage($event,image.id)">
                            <i class="pi pi-trash" style="font-size:.8rem"></i>
                        </div>
                        <!-- part of rendering the name of the file -->
                        <div class="text-xs text-gray-400 ml-1">
                            {{ image.originalName.substring(0, 10) }}...
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ConfirmPopup/>
    </div>
</template>

<script setup lang="ts">
import MemberImageDropZone from "@/components/member/memberImage/memberImageDropZone.vue";
import {ref} from "vue";
import {useMemberStore} from "@/store/member";
import {useConfirm} from "primevue/useconfirm";
import {deleteMemberImage} from "@/api/command/deleteMemberImage";
import {useToast} from "primevue/usetoast";
import {useAppStore} from "@/store/app";

const showDropZone = ref<boolean>(false);
const memberStore = useMemberStore();
const apiUrl = import.meta.env.VITE_API_URL;
const timestamp = new Date().getTime();
const confirm = useConfirm();
const toaster = useToast();
const appStore = useAppStore();

function showDropZoneHandler() {
    showDropZone.value = true;
}

function hideDropZoneHandler() {
    showDropZone.value = false;
}

function confirmDeleteMemberImage(event: MouseEvent, id: number) {
    const target = event.currentTarget;
    if (target instanceof HTMLElement) {
        confirm.require({
            target: target,
            message: "Ben je zeker?",
            icon: "pi pi-exclamation-triangle",
            acceptLabel: "Ja",
            rejectLabel: "Nee",
            acceptIcon: "pi pi-check",
            rejectIcon: "pi pi-times",
            accept: () => {
                void deleteMemberImageHandler(id);
            },
            reject: () => {
                // callback to execute when user rejects the action
            },
        });
    }
}

async function deleteMemberImageHandler(id: number) {
    let result = await deleteMemberImage(id);
    await memberStore.reloadMemberDetail();
    toaster.add({
        severity: "success",
        summary: "Foto succesvol verwijdert uit de lijst.",
        detail: "",
        life: appStore.toastLifeTime,
    });
}

</script>

<style>

.memberImage img {
    max-height: 150px;
    max-width: 750px;
    height: auto;
    width: auto;
}

</style>
