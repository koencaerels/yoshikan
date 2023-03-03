<template>
    <div id="subscriptionDetail">
        <!-- ------------------------------------------------------------------------------------------------------- -->
        <!-- -- step 1 -- check subscription -->
        <!-- ------------------------------------------------------------------------------------------------------- -->
        <div class="bg-gray-700 text-white p-2" v-if="memberStore.subscriptionDetail">
            <div class="flex flex-row">
                <div>
                    <div v-if="memberStore.subscriptionDetail.total == '0'">
                        <Button icon="pi pi-window-minimize"
                                class="p-button-sm p-button-warning"
                                @click="showEditSubscription=true"/>
                    </div>
                    <div v-else>
                        <Button icon="pi pi-window-minimize"
                                class="p-button-sm p-button-secondary"
                                @click="showEditSubscription=true"/>
                    </div>
                </div>
                <div class="ml-2 mt-1.5">
                    Stap 1: controleer en vervolledig de inschrijving:
                    <strong>YKS-{{ memberStore.subscriptionDetail.id }}</strong>
                </div>
            </div>
        </div>
        <detail-wrapper :estate-height="600" class="bg-gray-100">
            <div v-if="memberStore.subscriptionDetail" class="p-1 text-sm">
                <!-- nieuw lid -->
                <div class="bg-slate-200 flex p-1 rounded">
                    <div>
                        {{ memberStore.subscriptionDetail.period.name }} &mdash;
                    </div>
                    <div class="ml-2">
                        <div v-if="memberStore.subscriptionDetail.isNewMember"><i class="pi pi-user-plus"></i></div>
                        <div v-else><i class="pi pi-refresh"></i></div>
                    </div>
                    <div class="ml-3">
                        <strong>Nieuw lid?</strong>
                    </div>
                    <div class="ml-2">
                        <div v-if="memberStore.subscriptionDetail.isNewMember">Ja</div>
                        <div v-else>Nee</div>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/2 px-4">
                        <div><strong>Contact</strong></div>
                        {{ memberStore.subscriptionDetail.contactFirstname }}
                        {{ memberStore.subscriptionDetail.contactLastname }}
                        <br>&mdash; {{ memberStore.subscriptionDetail.contactEmail }}
                        <div v-if="memberStore.subscriptionDetail.contactPhone != ''">
                            &mdash; {{ memberStore.subscriptionDetail.contactPhone }}
                        </div>
                        <div v-if="memberStore.subscriptionDetail.isNewMember">
                            <div>
                                {{ memberStore.subscriptionDetail.addressStreet }}
                                {{ memberStore.subscriptionDetail.addressNumber }}
                                <span v-if="memberStore.subscriptionDetail.addressBox != ''">
                                    bus {{ memberStore.subscriptionDetail.addressBox }}
                                </span>
                            </div>
                            <div>
                                {{ memberStore.subscriptionDetail.addressZip }}
                                {{ memberStore.subscriptionDetail.addressCity }}
                            </div>
                            <div v-if="memberStore.subscriptionDetail.remarks != ''"
                                 class="p-1 text-xs bg-yellow-100 mt-2">
                                {{ memberStore.subscriptionDetail.remarks }}
                            </div>
                        </div>
                    </div>
                    <div class="basis-1/2 ml-2 mb-4">
                        <div><strong>Judoka</strong></div>
                        <div>
                            {{ memberStore.subscriptionDetail.firstname }} {{ memberStore.subscriptionDetail.lastname }}
                            (° {{ moment(memberStore.subscriptionDetail.dateOfBirth).format("DD/MM/YYYY") }}
                            <span v-if="memberStore.subscriptionDetail.isNewMember">
                                - {{ memberStore.subscriptionDetail.gender }}
                            </span>)
                        </div>
                        <div v-if="memberStore.subscriptionDetail.isNewMember">
                            {{ memberStore.subscriptionDetail.nationalRegisterNumber }}
                        </div>
                        <div>
                            &mdash; Locatie: {{ memberStore.subscriptionDetail.location.name }}
                        </div>
                        <div>
                            &mdash; Trainingen: {{ memberStore.subscriptionDetail.numberOfTraining }}x per week
                        </div>
                        <div v-if="memberStore.subscriptionDetail.isExtraTraining">
                            &mdash; 3 tot 5 trainingen
                        </div>
                        <div v-if="memberStore.subscriptionDetail.isReductionFamily">
                            &mdash; Gezinskorting
                        </div>
                        <div v-if="memberStore.subscriptionDetail.isJudogiBelt">
                            &mdash; Judopak + gordel
                            <span v-if="memberStore.subscriptionDetail.judogi">
                                ({{ memberStore.subscriptionDetail.judogi.name }})
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </detail-wrapper>
        <div class="p-2 bg-slate-300">
            <div class="flex" v-if="memberStore.subscriptionDetail">
                <div class="mr-2" v-if="memberStore.subscriptionDetail.total == '0'">
                    <div class="bg-yellow-300 text-red-600 px-2 cursor-pointer"
                         @click="showEditSubscription=true">
                        <i class="pi pi-exclamation-triangle"></i>
                    </div>
                </div>
                <div v-else>
                    <div class="text-green-600 px-2 cursor-pointer"
                         @click="showEditSubscription=true">
                        <i class="pi pi-check"></i>
                    </div>
                </div>
                <div>Totaal inschrijving:</div>
                <div class="ml-2">
                    <strong>{{ memberStore.subscriptionDetail.total }} €</strong>
                </div>
            </div>
        </div>

        <!-- ------------------------------------------------------------------------------------------------------- -->
        <!-- -- dialog change subscription -->
        <!-- ------------------------------------------------------------------------------------------------------- -->
        <Dialog v-model:visible="showEditSubscription" position="topright" v-if="memberStore.subscriptionDetail"
                :header="'Controleer inschrijving: YKS-'+memberStore.subscriptionDetail.id"
                :modal="true">
            <subscription-change v-on:saved="savedHandler"/>
        </Dialog>

        <!-- ------------------------------------------------------------------------------------------------------- -->
        <!-- -- step 2 -- change the status -->
        <!-- ------------------------------------------------------------------------------------------------------- -->
        <div class="bg-gray-700 text-white p-2" v-if="memberStore.subscriptionDetail">
            Stap 2: wijzig de status van de inschrijving: YKS-{{ memberStore.subscriptionDetail.id }}
        </div>
        <SubscriptionDetailStatus/>

        <!-- ------------------------------------------------------------------------------------------------------- -->
        <!-- -- step 3 -- connect to member -->
        <!-- ------------------------------------------------------------------------------------------------------- -->
        <div v-if="memberStore.subscriptionDetail">
            <div v-if="memberStore.subscriptionDetail.member">
                <div class="bg-gray-700 text-white p-2">Stap 3: gekoppeld lid voor deze inschrijving.</div>
            </div>
            <div v-else>
                <div class="bg-gray-700 text-white p-2">Stap 3: koppel bestaand lid of maak nieuw lid aan.</div>
            </div>
        </div>
        <SubscriptionDetailMember/>

    </div>
</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import {computed, ref} from "vue";
import {useAppStore} from "@/store/app";
import DetailWrapper from "@/components/wrapper/detailWrapper.vue";
import SubscriptionDetailStatus from "@/components/subscription/subscriptionDetailStatus.vue";
import SubscriptionDetailMember from "@/components/subscription/subscriptionDetailMember.vue";
import SubscriptionChange from "@/components/subscription/subscriptionChange.vue";
import moment from "moment";

const appStore = useAppStore();
const memberStore = useMemberStore();

const showEditSubscription = ref<boolean>(false);

function savedHandler() {
    showEditSubscription.value = false;
    memberStore.reloadSubscriptionDetail();
}

</script>
