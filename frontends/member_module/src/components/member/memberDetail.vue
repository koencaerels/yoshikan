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

        <detail-wrapper :estate-height="330" class="mt-2">

            <!-- -- grade logs --------------------------------------------- -->
            <div>
                <div v-for="gradeLog in memberStore.memberDetail.gradeLogs"
                     class="border-b-[1px] border-gray-300 pt-2 pb-2">
                    <div class="flex">
                        <div class="w-16 text-xs">
                            {{ moment(gradeLog.date).format("MM/YYYY") }}
                        </div>
                        <div class="w-16">
                            <div class="text-white rounded-full text-xs px-2 text-center"
                                 :style="'background-color:#'+gradeLog.fromGrade.color">
                                {{ gradeLog.fromGrade.name }}
                            </div>
                        </div>
                        <div class="w-4 text-center text-xs"> ></div>
                        <div class="w-16">
                            <div class="text-white rounded-full text-xs px-2 text-center"
                                 :style="'background-color:#'+gradeLog.toGrade.color">
                                {{ gradeLog.toGrade.name }}
                            </div>
                        </div>
                        <div class="ml-2 text-xs">
                            {{ gradeLog.remark }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- -- subscriptions ------------------------------------------ -->
            <div>
                <div v-for="subscription in memberStore.memberDetail.subscriptions"
                     class="border-b-[1px] border-gray-300 pt-2 pb-2">
                    <div class="flex">
                        <div class="w-16">
                            <div class="text-center rounded-full bg-green-800 text-white px-2 font-bold text-xs mt-1.5">
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
                <div class="content-wrapper p-4 text-sm">
                    <div v-html="memberStore.memberDetail.remarks">
                    </div>
                </div>

            </div>

        </detail-wrapper>
    </div>

    <!-- dialogs -->
    <Dialog v-model:visible="showDialogDetails"
            position="top"
            v-if="memberStore.memberDetail"
            :header="'Wijzig profiel voor '+memberStore.memberDetail.firstname+' '+memberStore.memberDetail.lastname"
            :modal="true">
        <dialog-change-details v-on:saved="hideDetailDialog"/>
    </Dialog>

    <Dialog v-model:visible="showDialogGrade"
            position="top"
            v-if="memberStore.memberDetail"
            :header="'Wijzig graad voor '+memberStore.memberDetail.firstname+' '+memberStore.memberDetail.lastname"
            :modal="true">
        <dialog-change-grade v-on:saved="hideGradeDialog"/>
    </Dialog>

    <Dialog v-model:visible="showDialogRemarks"
            position="top"
            v-if="memberStore.memberDetail"
            :header="'Wijzig opmerkingen voor '+memberStore.memberDetail.firstname+' '+memberStore.memberDetail.lastname"
            :modal="true">
        <dialog-change-remarks v-on:saved="hideRemarksDialog"/>
    </Dialog>

</template>

<script setup lang="ts">
import moment from "moment";
import MemberBadge from "@/components/member/memberBadge.vue";
import {useMemberStore} from "@/store/member";
import {ref} from "vue";
import DialogChangeDetails from "@/components/member/dialogChangeDetails.vue";
import DialogChangeGrade from "@/components/member/dialogChangeGrade.vue";
import DialogChangeRemarks from "@/components/member/dialogChangeRemarks.vue";
import DetailWrapper from "@/components/wrapper/detailWrapper.vue";

const memberStore = useMemberStore();
const showDialogDetails = ref<boolean>(false);
const showDialogGrade = ref<boolean>(false);
const showDialogRemarks = ref<boolean>(false);

function hideRemarksDialog() {
    showDialogRemarks.value = false;
}

function hideGradeDialog() {
    showDialogGrade.value = false;
}

function hideDetailDialog() {
    showDialogDetails.value = false;
}

</script>
