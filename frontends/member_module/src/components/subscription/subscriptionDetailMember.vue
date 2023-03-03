<template>
    <div id="subscriptionDetailMember">
        <div v-if="memberStore.subscriptionDetail">
            <div v-if="memberStore.subscriptionDetail.member" class="p-2">
                <member-badge :member="memberStore.subscriptionDetail.member"/>
            </div>
            <div v-else>
                <div v-if="isLoaded">
                    <div v-if="suggestedMembers.length > 0">
                        <div v-for="member in suggestedMembers" class="border-b-[1px] border-gray-300">
                            <div class="flex pt-1 pb-1">
                                <div class="">
                                    <Button
                                        v-if="!isLinking"
                                        @click="connectSubscriptionToMemberHandler(member.id)"
                                        icon="pi pi-link"
                                        label="Koppel"
                                        class="p-button-sm p-button-warning"/>
                                    <Button
                                        v-else
                                        disabled
                                        icon="pi pi-spinner pi-spin"
                                        label="Koppel"
                                        class="p-button-sm p-button-warning"/>
                                </div>
                                <div class="w-16 mt-1.5 ml-2">
                                    <div class="text-center rounded-full bg-blue-900 text-white px-2 font-bold text-xs">
                                        YK-{{ member.id }}
                                    </div>
                                </div>
                                <div class="w-48 ml-2 font-bold">
                                    {{ member.firstname }} {{ member.lastname }}
                                </div>
                                <div class="w-36 ml-2 text-sm mt-0.5">
                                    ° {{ moment(member.dateOfBirth).format("DD/MM/YYYY") }}
                                    - {{ member.gender }}
                                </div>
                                <div class="w-16 ml-2 mt-1">
                                    <div class="text-white rounded-full text-xs px-2 text-center"
                                         :style="'background-color:#'+member.grade.color">
                                        {{ member.grade.name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="p-4">
                            Geen suggestie gevonden bij de bestaande leden...
                        </div>
                    </div>
                    <div class="px-4 py-2">
                        <div>
                            <div v-if="suggestedMembers.length > 0" class="flex">
                                of&nbsp;&nbsp;
                                <div class="bg-yellow-200 text-xs text-gray-500 px-2 py-1 rounded cursor-pointer"
                                     @click="confirmCreateMember($event)">
                                    Maak nieuw lid aan op basis van de inschrijving
                                </div>
                            </div>
                            <div v-else>
                                <Button
                                    v-if="!isCreating"
                                    @click="confirmCreateMember($event)"
                                    label="Maak nieuw lid aan op basis van de inschrijving"
                                    icon="pi pi-user-plus"
                                    class="p-button-warning p-button-sm"/>
                                <Button
                                    v-else
                                    disabled
                                    label="Maak nieuw lid aan op basis van de inschrijving"
                                    icon="pi pi-spinner pi-spin"
                                    class="p-button-warning p-button-sm"/>
                            </div>
                        </div>
                        <ConfirmPopup/>
                    </div>
                </div>
                <div v-else>
                    <div class="text-center mt-4">
                        <i class="pi pi-spinner pi-spin"></i>
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
import {onMounted, ref} from "vue";
import {createMemberFromSubscription} from "@/api/command/createMemberFromSubscription";
import MemberBadge from "@/components/member/memberBadge.vue";
import {suggestMember} from "@/api/query/suggestMember";
import type {MemberSuggestModel} from "@/api/query/suggestMember";
import moment from "moment";
import {useConfirm} from "primevue/useconfirm";
import type {ConnectSubscriptionToMemberCommand} from "@/api/command/connectSubscriptionToMember";
import {connectSubscriptionToMember} from "@/api/command/connectSubscriptionToMember";
import type {Member} from "@/api/query/model";

const appStore = useAppStore();
const memberStore = useMemberStore();
const toaster = useToast();
const isCreating = ref<boolean>(false);
const isLinking = ref<boolean>(false);
const suggestedMembers = ref<Member[]>([]);
const confirm = useConfirm();
const isLoaded = ref<boolean>(false);

onMounted(() => {
    void suggestMembersHandler();
});

function confirmCreateMember(event: MouseEvent) {
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
                void createMemberFromSubscriptionHandler();
            },
            reject: () => {
                // callback to execute when user rejects the action
            },
        });
    }
}

async function suggestMembersHandler() {
    let suggestModel: MemberSuggestModel = {
        firstname: memberStore.subscriptionDetail?.firstname ?? '',
        lastname: memberStore.subscriptionDetail?.lastname ?? '',
        dateOfBirth: memberStore.subscriptionDetail?.dateOfBirth ?? new Date(),
    };
    suggestedMembers.value = await suggestMember(suggestModel);
    isLoaded.value = true;
}

async function createMemberFromSubscriptionHandler() {
    isCreating.value = true;
    await createMemberFromSubscription(memberStore.subscriptionDetail?.id ?? 0);
    await memberStore.reloadSubscriptionDetail();
    memberStore.increaseCounter();
    toaster.add({
        severity: "success",
        summary: "Nieuw lid aangemaakt op basis van de inschrijving.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    isCreating.value = false;
}

async function connectSubscriptionToMemberHandler(memberId: number) {
    isLinking.value = true;
    let command: ConnectSubscriptionToMemberCommand = {
        id: memberStore.subscriptionDetail?.id ?? 0,
        memberId: memberId
    }
    await connectSubscriptionToMember(command);
    await memberStore.reloadSubscriptionDetail();
    memberStore.increaseCounter();
    toaster.add({
        severity: "success",
        summary: "Inschrijving is gekoppeld aan bestaand lid.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    isLinking.value = false;
}

</script>
