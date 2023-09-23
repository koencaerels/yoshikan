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
    <div id="memberDetail" class="p-4" v-if="memberStore.memberDetail">
        <div class="flex text-sm mb-4">

            <div v-if="(type == 'partial')"
                 class="bg-gray-200 rounded-full px-2 py-1">
                <router-link :to="'/lid/'+memberStore.memberId">
                    <i class="pi pi-eye"></i>
                </router-link>
            </div>
            <div v-if="(type == 'detail')"
                 class="bg-gray-200 rounded-full px-2 py-1">
                <router-link :to="'/leden'">
                    <i class="pi pi-times"></i>
                </router-link>
            </div>

            <div class="ml-4">
                Wijzig >
            </div>
            <div class="ml-2 cursor-pointer underline text-blue-400" @click="(showDialogDetails = true)">
                Profiel
            </div>
            <div class="ml-4 cursor-pointer underline text-blue-400" @click="(showDialogGrade = true)">
                Graad
            </div>
            <div class="ml-4 cursor-pointer underline text-blue-400" @click="(showDialogRemarks = true)">
                Opmerkingen
            </div>
            <div class="ml-4 cursor-pointer underline text-blue-400" @click="(showDialogProfileImage = true)">
                Profiel foto
            </div>

        </div>

        <!-- -- member badge --------------------------------------------------------------------------------------- -->
        <member-badge :member="memberStore.memberDetail"/>

        <TabView>

            <!-- -- profile ---------------------------------------------------------------------------------------- -->
            <TabPanel header="Profiel">
                <detail-wrapper :estate-height="estateHeight" class="p-2">
                    <profile-detail/>
                </detail-wrapper>
            </TabPanel>

            <!-- -- grade logs ------------------------------------------------------------------------------------- -->
            <TabPanel header="Graden">
                <detail-wrapper :estate-height="estateHeight" class="p-2">
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
                    <div class="mt-2">
                        <add-button @click="(showDialogGrade = true)"/>
                    </div>
                </detail-wrapper>
            </TabPanel>

            <!-- -- opmerkingen ------------------------------------------------------------------------------------ -->
            <TabPanel header="Opmerkingen">
                <detail-wrapper :estate-height="estateHeight">
                    <div class="content-wrapper p-4 text-sm">
                        <div v-html="memberStore.memberDetail.remarks"/>
                    </div>
                    <div>
                        <edit-button @click="(showDialogRemarks = true)"/>
                    </div>
                </detail-wrapper>
            </TabPanel>

            <!-- -- subscriptions ---------------------------------------------------------------------------------- -->
            <TabPanel header="Inschrijvingen">
                <detail-wrapper :estate-height="estateHeight" class="p-2">
                    todo
                </detail-wrapper>
            </TabPanel>

            <!-- -- berichten -------------------------------------------------------------------------------------- -->
            <TabPanel header="Berichten">
                <detail-wrapper :estate-height="estateHeight" class="p-2">
                    berichten todo
                </detail-wrapper>
            </TabPanel>

        </TabView>
    </div>

    <!-- ----------------------------------------------------------------------------------------------------------- -->
    <!-- dialogs                                                                                                     -->
    <!-- ----------------------------------------------------------------------------------------------------------- -->

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

    <Dialog v-model:visible="showDialogProfileImage"
            position="top"
            v-if="memberStore.memberDetail"
            :header="'Wijzig profielfoto voor '+memberStore.memberDetail.firstname+' '+memberStore.memberDetail.lastname"
            :modal="true">
        <dialog-change-profile-image v-on:saved="hideProfileImageDialog"/>
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
import GroupRenderer from "@/components/member/groupRenderer.vue";
import DialogChangeProfileImage from "@/components/member/dialogChangeProfileImage.vue";
import {useToast} from "primevue/usetoast";
import {useAppStore} from "@/store/app";
import SubscriptionAdd from "@/components/subscription/subscriptionAdd.vue";
import EditButton from "@/components/common/editButton.vue";
import AddButton from "@/components/common/addButton.vue";
import ProfileDetail from "@/components/member/profile/profileDetail.vue";

const memberStore = useMemberStore();
const showDialogDetails = ref<boolean>(false);
const showDialogGrade = ref<boolean>(false);
const showDialogRemarks = ref<boolean>(false);
const showDialogProfileImage = ref<boolean>(false);
const showNewSubscription = ref<boolean>(false);
const toaster = useToast();
const appStore = useAppStore();

const props = defineProps<{
    type: 'dialog' | 'detail' | 'partial',
    estateHeight: number,
}>();

function hideRemarksDialog() {
    showDialogRemarks.value = false;
}

function hideGradeDialog() {
    showDialogGrade.value = false;
}

function hideDetailDialog() {
    showDialogDetails.value = false;
}

function hideProfileImageDialog() {
    memberStore.reloadMemberDetail();
    toaster.add({
        severity: "success",
        summary: "Profiel foto aangepast.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    showDialogProfileImage.value = false;
}

function subscribeHandler() {
    showNewSubscription.value = false;
}

</script>
