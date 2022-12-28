<template>
    <div class="px-4 py-2" v-if="memberStore.subscriptionDetail">
        <div class="flex flex-row">
            <div class="basis-1/2">
                <div class="px-2 bg-sky-400 rounded-full text-white text-xs w-32 text-center">
                    {{ memberStore.subscriptionDetail.location.name }}
                </div>
                <subscription-tag :subscription="memberStore.subscriptionDetail" class="mt-2"/>
                <div class="mt-2">
                    <strong>{{ memberStore.subscriptionDetail.firstname }}
                        {{ memberStore.subscriptionDetail.lastname }}</strong>
                    <span class="text-xs"> (°
                            {{ moment(memberStore.subscriptionDetail.dateOfBirth).format("DD/MM/YYYY") }}
                        - {{ memberStore.subscriptionDetail.gender }}
                        )</span>
                </div>
            </div>
            <div class="basis-1/2">
                <div class="flex">
                    <div class="w-full">
                        <Dropdown class="w-full" v-model="newStatus" :options="status"/>
                    </div>
                    <div>
                        <Button icon="pi pi-save" class="p-button-success"/>
                    </div>
                </div>
                <div class="mt-2 pb-2">
                    <div class="cursor-pointer">
                        <i class="pi pi-envelope"></i> Verzend email met betalings instructies.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import moment from "moment";
import {useMemberStore} from "@/store/member";
import {ref} from "vue";

const memberStore = useMemberStore();
const newStatus = ref<string>(memberStore.subscriptionDetail?.status ?? 'nieuw');
const status = ['nieuw', 'wachtend op betaling', 'betaald', 'afgewezen'];

</script>
