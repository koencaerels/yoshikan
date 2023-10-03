<template>
    <div id="dialogChangeDetails" style="width:800px;" class="text-sm" v-if="memberStore.messageDetail">
        <div class="border-b-[1px] border-gray-400 py-1 flex gap-2">
            <div class="w-24 text-right text-xs">verzonden op</div>
            <div>{{ moment(memberStore.messageDetail.sendOn).format("DD/MM/YYYY H:mm") }}</div>
        </div>
        <div class="border-b-[1px] border-gray-400 py-1  flex gap-2">
            <div class="w-24 text-right text-xs">van</div>
            <div>
                {{ memberStore.messageDetail.fromName }} &lt;{{ memberStore.messageDetail.fromEmail }}&gt;
            </div>
        </div>
        <div class="border-b-[1px] border-gray-400 py-1  flex gap-2">
            <div class="w-24 text-right text-xs">naar</div>
            <div>
                {{ memberStore.messageDetail.toName }} &lt;{{ memberStore.messageDetail.toEmail }}&gt;
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
        <div v-html="memberStore.messageDetail.message"></div>
    </div>

</template>

<script setup lang="ts">
import moment from "moment/moment";
import {useMemberStore} from "@/store/member";
import {ref} from "vue";
import {resendMessage} from "@/api/command/message/resendMessage";
import type {ResendMessageCommand} from "@/api/command/message/resendMessage";
import {email, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {useAppStore} from "@/store/app";
import {useToast} from "primevue/usetoast";

const memberStore = useMemberStore();
const appStore = useAppStore();
const toaster = useToast();

const doResendMessage = ref<boolean>(false);
const isMessageSend = ref<boolean>(false);
const isSending = ref<boolean>(false);

const command = ref<ResendMessageCommand>({
    messageId: memberStore.messageDetail?.id ?? 0,
    toEmail: memberStore.messageDetail?.toEmail ?? ''
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
