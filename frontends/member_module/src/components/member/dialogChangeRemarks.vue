<template>
    <div id="dialogChangeRemarks" style="width:600px;">
        <div>
            <simple-editor v-model="remarks"/>
        </div>
        <div class="flex flex-row mt-4">
            <div class="basis-1/2">&nbsp;</div>
            <div class="basis-1/2">
                <Button label="Bewaar"
                        icon="pi pi-save"
                        class="p-button-success p-button-sm w-full"></Button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import SimpleEditor from "@/components/editor/simpleEditor.vue";
import {useMemberStore} from "@/store/member";
import {ref} from "vue";

const memberStore = useMemberStore();
const remarks = ref<string>(memberStore.memberDetail?.remarks ?? '');

</script>
