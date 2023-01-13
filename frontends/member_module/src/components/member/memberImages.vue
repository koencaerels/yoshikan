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
                        <div class="text-xs text-gray-400">
                            {{image.originalName.substring(0,15)}}...
                        </div>
                        <!-- delete button -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import MemberImageDropZone from "@/components/member/memberImage/memberImageDropZone.vue";
import {ref} from "vue";
import {useMemberStore} from "@/store/member";

const showDropZone = ref<boolean>(false);
const memberStore = useMemberStore();
const apiUrl = import.meta.env.VITE_API_URL;
const timestamp = new Date().getTime();

function showDropZoneHandler() {
    showDropZone.value = true;
}

function hideDropZoneHandler() {
    showDropZone.value = false;
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
