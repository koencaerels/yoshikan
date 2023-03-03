<template>
    <div id="memberDetail" class="p-4" v-if="memberStore.memberDetail">
        <div class="flex text-sm mb-4">
            <div v-if="!isDetail"
                 class="bg-gray-200 rounded-full px-2 py-1">
                <router-link :to="'/lid/'+memberStore.memberId">
                    <i class="pi pi-eye"></i>
                </router-link>
            </div>
            <div v-else
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
            <div class="ml-4 cursor-pointer underline text-blue-400" @click="(showNewSubscription = true)">
                Inschrijven
            </div>
        </div>

        <!-- -- member badge ------------------------------------------- -->
        <member-badge :member="memberStore.memberDetail"/>
        <TabView>
            <TabPanel header="Graden">
                <!-- -- grade logs --------------------------------------------- -->
                <detail-wrapper :estate-height="370" class="p-2">
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
            <TabPanel header="Profiel">
                <detail-wrapper :estate-height="370" class="p-2">
                    <div class="p-2">
                        <div class="flex flex-row">
                            <div class="basis-1/2">
                                <div><strong>Judoka</strong></div>
                                <hr>
                                <div class="mt-2">
                                    {{memberStore.memberDetail.firstname}}
                                    {{memberStore.memberDetail.lastname}}
                                </div>
                                <div class="text-xs mt-1">
                                    &mdash; {{ memberStore.memberDetail.nationalRegisterNumber }}
                                </div>
                                <div class="mt-2">
                                    ° {{ moment(memberStore.memberDetail.dateOfBirth).format("DD/MM/YYYY") }}
                                    - {{ memberStore.memberDetail.gender }}
                                </div>

                                <div class="mt-8 pr-8">
                                    <div :style="'background-color: #'+memberStore.memberDetail.grade.color"
                                         class="rounded-full text-white px-2 font-bold text-center w-32 text-sm">
                                        {{ memberStore.memberDetail.grade.name }}
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="px-2 bg-sky-400 rounded-full text-white text-xs w-32 text-center">
                                        {{ memberStore.memberDetail.location.name }}
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <group-renderer :member="memberStore.memberDetail"/>
                                </div>
                            </div>
                            <div class="basis-1/2">
                                <div v-if="memberStore.memberDetail.subscriptions && memberStore.memberDetail.subscriptions.length != 0">
                                    <div><strong>Contact</strong></div>
                                    <hr>
                                    <div class="mt-2">
                                        {{ memberStore.memberDetail.subscriptions[0].contactFirstname }}
                                        {{ memberStore.memberDetail.subscriptions[0].contactLastname }}
                                    </div>
                                    <div>
                                        &mdash; {{ memberStore.memberDetail.subscriptions[0].contactEmail}}
                                    </div>
                                    <div v-if="memberStore.memberDetail.subscriptions[0].contactPhone != ''">
                                        &mdash; {{ memberStore.memberDetail.subscriptions[0].contactPhone}}
                                    </div>
                                    <div class="mt-4">
                                        <div>
                                            {{memberStore.memberDetail.addressStreet}}
                                            {{memberStore.memberDetail.addressNumber}}
                                            <span v-if="memberStore.memberDetail.addressBox != ''">
                                                bus {{memberStore.memberDetail.addressBox}}
                                            </span>
                                        </div>
                                        <div>
                                            {{memberStore.memberDetail.addressZip}}
                                            {{memberStore.memberDetail.addressCity}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-1">
                        <edit-button @click="(showDialogDetails = true)"/>
                    </div>
                </detail-wrapper>
            </TabPanel>
            <TabPanel header="Opmerkingen">
                <!-- -- opmerkingen -------------------------------------------- -->
                <detail-wrapper :estate-height="370">
                    <div class="content-wrapper p-4 text-sm">
                        <div v-html="memberStore.memberDetail.remarks">
                        </div>
                    </div>
                    <div>
                        <edit-button @click="(showDialogRemarks = true)"/>
                    </div>
                </detail-wrapper>
            </TabPanel>
            <TabPanel header="Inschrijvingen">
                <!-- -- subscriptions ------------------------------------------ -->
                <detail-wrapper :estate-height="370" class="p-2">
                    <div v-for="subscription in memberStore.memberDetail.subscriptions"
                         class="border-b-[1px] border-gray-300 pt-2 pb-2">
                        <div class="flex">
                            <div class="w-16">
                                <div
                                    class="text-center rounded-full bg-green-800 text-white px-2 font-bold text-xs mt-1.5">
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
                    <div class="mt-2">
                        <add-button @click="(showNewSubscription = true)"/>
                    </div>
                </detail-wrapper>
            </TabPanel>
        </TabView>
    </div>

    <!-- -- dialog new subscription -->
    <Dialog v-model:visible="showNewSubscription" position="topleft" v-if="appStore.configuration"
            :header="'Voeg een inschrijving toe voor '+appStore.configuration.activePeriod.name"
            :modal="true">
        <subscription-add v-on:subscribed="subscribeHandler"
                          :member-id="memberStore.memberId"/>
    </Dialog>

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

const memberStore = useMemberStore();
const showDialogDetails = ref<boolean>(false);
const showDialogGrade = ref<boolean>(false);
const showDialogRemarks = ref<boolean>(false);
const showDialogProfileImage = ref<boolean>(false);
const showNewSubscription = ref<boolean>(false);
const toaster = useToast();
const appStore = useAppStore();


const props = defineProps<{
    isDetail: boolean,
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
