<template>
    <div id="subscriptionDetailMember">
        <div v-if="memberStore.subscriptionDetail">
            <div v-if="memberStore.subscriptionDetail.member" class="p-2">
                <member-badge :member="memberStore.subscriptionDetail.member"/>
            </div>
            <div v-else>
                <div class="px-4 py-2">
                    <div>
                        <Button
                            @click="createMemberFromSubscriptionHandler"
                            label="Maak nieuw lid aan"
                            icon="pi pi-user"
                            class="p-button-success p-button-sm"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {useMemberStore} from "@/store/member";
import {useToast} from "primevue/usetoast";
import {ref} from "vue";
import {createMemberFromSubscription} from "@/api/command/createMemberFromSubscription";
import MemberBadge from "@/components/member/memberBadge.vue";

const appStore = useAppStore();
const memberStore = useMemberStore();
const toaster = useToast();
const isCreating = ref<boolean>(false);
const isLinking = ref<boolean>(false);

async function createMemberFromSubscriptionHandler() {
    isCreating.value = true;
    await createMemberFromSubscription(memberStore.subscriptionDetail?.id ?? 0);
    await memberStore.reloadSubscriptionDetail();
    toaster.add({
        severity: "success",
        summary: "Nieuw lid aangemaakt op basis van de inschrijving.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    isCreating.value = false;
}

</script>
