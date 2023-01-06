<template>
    <div id="memberDetail" class="p-4" v-if="memberStore.memberDetail">

        <div class="flex text-sm underline mb-4 text-blue-400">
            <div class="cursor-pointer" @click="(showDialogDetails = true)">
                Wijzig profiel
            </div>
            <div class="ml-4 cursor-pointer" @click="(showDialogGrade = true)">
                Wijzig graad
            </div>
            <div class="ml-4 cursor-pointer" @click="(showDialogRemarks = true)">
                Wijzig opmerkingen
            </div>
            <!--            <div class="ml-4 cursor-pointer">-->
            <!--                Wijzig foto-->
            <!--            </div>-->
            <!--            <div class="ml-4 cursor-pointer">-->
            <!--                Voeg inschrijving toe-->
            <!--            </div>-->
        </div>

        <!-- -- member badge ------------------------------------------- -->
        <member-badge :member="memberStore.memberDetail"/>

        <!-- -- subscriptions ------------------------------------------ -->
        <div>
            <div v-for="subscription in memberStore.memberDetail.subscriptions"
                 class="border-b-[1px] border-gray-300 pt-2 pb-2">
                <div class="flex">
                    <div class="w-16">
                        <div class="text-center rounded-full bg-green-600 text-white px-2 font-bold text-xs mt-1.5">
                            YKS-{{ subscription.id }}
                        </div>
                    </div>
                    <div class="w-48 ml-2 font-bold">{{ subscription.period.name }}</div>
                    <div class="w-32 ml-2">{{ subscription.type }}</div>
                    <div>
                        {{ subscription.numberOfTraining }} x training per week
                    </div>
                </div>
            </div>
        </div>

        <!-- -- opmerkingen -------------------------------------------- -->
        <div>
            <div class="border-b-[1px] border-gray-300 pt-2 pb-2 font-bold text-xs">
                Opmerkingen
            </div>
            <div v-html="memberStore.memberDetail.remarks">
            </div>
        </div>
    </div>

    <!-- dialogs -->
    <Dialog v-model:visible="showDialogDetails"
            position="top"
            v-if="memberStore.memberDetail"
            :header="'Wijzig details voor '+memberStore.memberDetail.firstname+' '+memberStore.memberDetail.lastname"
            :modal="true">
        <dialog-change-details/>
    </Dialog>

    <Dialog v-model:visible="showDialogGrade"
            position="top"
            v-if="memberStore.memberDetail"
            :header="'Wijzig graad voor '+memberStore.memberDetail.firstname+' '+memberStore.memberDetail.lastname"
            :modal="true">
        <dialog-change-grade/>
    </Dialog>

    <Dialog v-model:visible="showDialogRemarks"
            position="top"
            v-if="memberStore.memberDetail"
            :header="'Wijzig opmerkingen voor '+memberStore.memberDetail.firstname+' '+memberStore.memberDetail.lastname"
            :modal="true">
        <dialog-change-remarks/>
    </Dialog>

</template>

<script setup lang="ts">
import MemberBadge from "@/components/member/memberBadge.vue";
import {useMemberStore} from "@/store/member";
import {ref} from "vue";
import DialogChangeDetails from "@/components/member/dialogChangeDetails.vue";
import DialogChangeGrade from "@/components/member/dialogChangeGrade.vue";
import DialogChangeRemarks from "@/components/member/dialogChangeRemarks.vue";

const memberStore = useMemberStore();
const showDialogDetails = ref<boolean>(false);
const showDialogGrade = ref<boolean>(false);
const showDialogRemarks = ref<boolean>(false);

</script>
