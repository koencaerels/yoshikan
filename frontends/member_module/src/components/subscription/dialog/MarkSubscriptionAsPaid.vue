<!--
/*
* This file is part of the Yoshi-Kan software.
*
* (c) Koen Caerels
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
-->

<template>
    <div class="p-8 w-[350px]" v-if="!isLoading">
        <div class="p-4">
            <Button @click="markAsPaid('overschrijving')"
                    class="p-button-success w-full p-button-lg h-32"
                    label="Overschrijving"/>
        </div>
        <div class="p-4">
            <Button @click="markAsPaid('contant')"
                    class="p-button-success w-full p-button-lg h-32"
                    label="Contant"/>
        </div>
    </div>
    <div v-else class="p-16 w-[350px] text-center">
        <ProgressSpinner/>
    </div>
</template>

<script setup lang="ts">
import type {MarkSubscriptionAsPayedCommand} from "@/api/command/subscription/markSubscriptionAsPayed";
import {markSubscriptionAsPayed} from "@/api/command/subscription/markSubscriptionAsPayed";
import {ref} from "vue";
import {useMemberStore} from "@/store/member";
import {useToast} from "primevue/usetoast";
import {useAppStore} from "@/store/app";

const memberStore = useMemberStore();
const isLoading = ref<boolean>(false);
const toaster = useToast();
const appStore = useAppStore();

const emit = defineEmits(["paid"]);

const commandPay = ref<MarkSubscriptionAsPayedCommand>({
    id: memberStore.subscriptionDetail?.id ?? 0,
    type: "overschrijving",
});

async function markAsPaid(type:string) {
    if (commandPay.value.id !== 0) {
        isLoading.value = true;
        commandPay.value.type = type;
        let result = await markSubscriptionAsPayed(commandPay.value);
        toaster.add({
            severity: "success",
            summary: "Betaling ("+type+") voor de inschrijving is geconfirmeerd.",
            detail: "",
            life: appStore.toastLifeTime,
        });
        await memberStore.reloadSubscriptionDetail();
        await memberStore.reloadMemberDetail();
        memberStore.increaseCounter();
        isLoading.value = false;
        emit('paid');
    }
}

</script>

<style scoped>

</style>
