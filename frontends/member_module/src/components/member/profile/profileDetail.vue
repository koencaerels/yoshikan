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
    <div>
        <div class="flex flex-row">
            <div class="basis-1/2">
                <div>
                    <span class="uppercase">{{ memberStore.memberDetail.lastname }}</span>
                    {{ memberStore.memberDetail.firstname }}
                </div>
                <div class="text-xs mt-1">
                    &mdash; {{ memberStore.memberDetail.nationalRegisterNumber }}
                </div>
                <div class="mt-2">
                    ° {{ moment(memberStore.memberDetail.dateOfBirth).format("DD/MM/YYYY") }}
                    - {{ memberStore.memberDetail.gender }}
                </div>
                <div class="mt-4">
                    <div :style="'background-color: #'+memberStore.memberDetail.grade.color"
                         class="rounded-full text-white px-2 font-bold text-center w-32 text-sm">
                        {{ memberStore.memberDetail.grade.name }}
                    </div>
                </div>
                <div class="mt-1">
                    <div class="px-2 bg-sky-400 rounded-full text-white text-xs w-32 text-center">
                        {{ memberStore.memberDetail.location.name }}
                    </div>
                </div>
                <div class="mt-1">
                    <group-renderer :member="memberStore.memberDetail"/>
                </div>
            </div>
            <div class="basis-1/2 text-sm" >
                <div class="mb-4">
                    <div class="text-xs text-gray-300 w-10 float-left">email</div>
                    {{ memberStore.memberDetail.email }}
                </div>
                <hr>
                <div class="mt-4 mb-4">
                    <div>
                        {{ memberStore.memberDetail.addressStreet }}
                        {{ memberStore.memberDetail.addressNumber }}
                        <span v-if="memberStore.memberDetail.addressBox != ''">
                                bus {{ memberStore.memberDetail.addressBox }}
                            </span>
                    </div>
                    <div>
                        {{ memberStore.memberDetail.addressZip }}
                        {{ memberStore.memberDetail.addressCity }}
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import moment from "moment/moment";
import GroupRenderer from "@/components/member/groupRenderer.vue";
import {useMemberStore} from "@/store/member";

const memberStore = useMemberStore();

</script>
