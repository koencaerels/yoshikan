<template>

    <!-- -- list --------------------------------------------------------------------------------------------------- -->
    <div id="memberOverviewMessages">
        <div v-for="message in memberStore.memberMessages">
            <div @click="showMessageDetailFn(message)"
                 class="flex gap-2 text-sm border-b-[1px] border-gray-400 py-1 hover:bg-gray-200 cursor-pointer">
                <div class="flex-none w-32">
                    <div class="text-xs">
                        op {{ moment(message.sendOn).format("DD/MM/YYYY H:mm") }}:
                    </div>
                </div>
                <div class="flex-none w-32 px-2 rounded-full bg-blue-100 text-xs pt-0.5">
                    <div class="line-clamp-1">
                        {{ message.toEmail }}
                    </div>
                </div>
                <div class="text-sm grow">
                    <div class="line-clamp-1">
                        {{ message.subject }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- -- detail ------------------------------------------------------------------------------------------------- -->
    <Dialog v-model:visible="showMessageDetail"
            v-if="messageDetailObject"
            :header="messageDetailObject.subject"
            :modal="true">
        <message-detail/>
    </Dialog>

</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import moment from "moment";
import {ref, watch} from "vue";
import type {Message} from "@/api/query/model";
import MessageDetail from "@/components/message/messageDetail.vue";

const memberStore = useMemberStore();
const messageDetailObject = ref<Message>();

const showMessageDetail = ref<boolean>(false);
async function showMessageDetailFn(message: Message) {
    messageDetailObject.value = message;
    await memberStore.loadMessageDetail(message.id);
    showMessageDetail.value = true;
}

</script>

<style scoped>

</style>
