<template>
    <div id="memberImageDropZone" class="border-[1px] p-2 border-gray-400 rounded">
        <div class="float-right">
            <close-button @click="closeDropZone"></close-button>
        </div>
        <div>
            <div class="dropzone" ref="dropzoneRef" id="dropZoneMemberImage">
                <div class="ml-2 mt-2 text-xs text-gray-400">
                    Image (jpg, png, gif) files only, max size 3MB.
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import Dropzone from "dropzone";
import CloseButton from "@/components/common/closeButton.vue";
import {onMounted, ref} from "vue";
import {useMemberStore} from "@/store/member";

const apiUrl = import.meta.env.VITE_API_URL;
const dropzoneRef = ref(null);
const timestamp = new Date().getTime();

const emit = defineEmits(["close"]);
const memberStore = useMemberStore();

onMounted((): void => {
    if (dropzoneRef.value !== null) {
        let dropzone = new Dropzone(dropzoneRef.value, {
            url: apiUrl + '/member/' + memberStore.memberId + '/upload',
            maxFiles: 5,
            acceptedFiles: '.png,.bmp,.jpg,.jpeg',
            paramName: 'memberImage',
            maxFilesize: 3,
            thumbnailWidth: 70,
            thumbnailHeight: 70
        });
        dropzone.on("complete", file => {
            dropzone.removeFile(file);
            memberStore.reloadMemberDetail();
        });
    }
});

function closeDropZone() {
    emit('close');
}

</script>

<style scoped>
    #dropZoneMemberImage {
        height: 200px !important;
        padding: 2px !important;
    }
</style>
