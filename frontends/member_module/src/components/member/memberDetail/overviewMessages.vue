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
            v-if="messageDetail"
            :header="messageDetail.subject"
            :modal="true">
        <div id="dialogChangeDetails" style="width:800px;" class="text-sm">
            <div class="border-b-[1px] border-gray-400 py-1 flex gap-2">
                <div class="w-24 text-right text-xs">verzonden op</div>
                <div>{{ moment(messageDetail.sendOn).format("DD/MM/YYYY H:mm") }}</div>
            </div>
            <div class="border-b-[1px] border-gray-400 py-1  flex gap-2">
                <div class="w-24 text-right text-xs">van</div>
                <div>
                    {{ messageDetail.fromName }} &lt;{{ messageDetail.fromEmail }}&gt;
                </div>
            </div>
            <div class="border-b-[1px] border-gray-400 py-1  flex gap-2">
                <div class="w-24 text-right text-xs">naar</div>
                <div>
                    {{ messageDetail.toName }} &lt;{{ messageDetail.toEmail }}&gt;
                </div>
            </div>
            <div class="border-b-[1px] border-gray-400 flex gap-2 p-2">
                <div class="mt-0.5" v-if="!isMessageSend">
                    <InputSwitch v-model="doResendMessage"/>
                </div>
                <div v-if="!isMessageSend">opnieuw verzenden</div>
                <div v-if="doResendMessage">naar</div>
                <div v-if="doResendMessage" class="flex-non w-96">
                    <div>
                        <span class="p-input-icon-right w-full">
                            <InputText class="w-full p-inputtext-sm" v-model="command.toEmail"/>
                            <i v-if="!resend$.toEmail.$invalid" class="pi pi-check text-green-600"/>
                            <i v-if="resend$.toEmail.$invalid" class="pi pi-times text-red-600"/>
                        </span>
                    </div>
                </div>
                <div v-if="doResendMessage">
                    <Button v-if="!isSending"
                            label="Verzend bericht"
                            @click="resendMessageFn"
                            icon="pi pi-send"
                            class="p-button-success p-button-sm w-full"/>
                    <Button v-else disabled
                            label="Verzend bericht"
                            icon="pi pi-spinner pi-spin"
                            class="p-button-success p-button-sm w-full"/>
                </div>
            </div>

            <div v-html="messageDetail.message"></div>
        </div>
    </Dialog>

</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import moment from "moment";
import {ref, watch} from "vue";
import type {Message} from "@/api/query/model";
import type {ResendMessageCommand} from "@/api/command/message/resendMessage";
import {email, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {useToast} from "primevue/usetoast";
import {useAppStore} from "@/store/app";
import {resendMessage} from "@/api/command/message/resendMessage";

const memberStore = useMemberStore();
const showMessageDetail = ref<boolean>(false);
const messageDetail = ref<Message>();
const doResendMessage = ref<boolean>(false);
const isMessageSend = ref<boolean>(false);
const isSending = ref<boolean>(false);
const toaster = useToast();
const appStore = useAppStore();

function showMessageDetailFn(message: Message) {
    messageDetail.value = message;
    showMessageDetail.value = true;
    isMessageSend.value = false;
    doResendMessage.value = false;
}

watch(showMessageDetail, (): void => {
    command.value.messageId = messageDetail.value?.id ?? 0;
    command.value.toEmail = messageDetail.value?.toEmail ?? '';
});

const command = ref<ResendMessageCommand>({
    messageId: messageDetail.value?.id ?? 0,
    toEmail: messageDetail.value?.toEmail ?? ''
});

const rules = {
    toEmail: {required, email}
};

const resend$ = useVuelidate(rules, command);

async function resendMessageFn() {
    if (!resend$.value.$invalid) {
        isSending.value = true;
        let result = await resendMessage(command.value)
        toaster.add({
            severity: "success",
            summary: "Bericht is opnieuw verzonden.",
            detail: "",
            life: appStore.toastLifeTime,
        });
        isSending.value = false;
        doResendMessage.value = false;
        isMessageSend.value = true;
    }
}

</script>

<style scoped>

</style>
