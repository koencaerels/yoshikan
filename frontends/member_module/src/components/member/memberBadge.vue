<template>
    <div id="memberBadge" class="border-[1px] rounded-lg border-blue-900">
        <div class="flex-row flex">
            <div class="basis-3/12 rounded-l-lg text-right"
                 :style="'background-color: #'+member.grade.color">
                <div v-if="member.profileImage !== ''"
                     class="text-right rounded-l-lg"
                     style="width:160px;height:140px;float:right;">
                    <Image style="width:140px;height:140px;"
                           :src="apiUrl+'/member/'+member.id+'/profile-image?t=' + timestamp"
                           :alt="member.firstname+' '+member.lastname" preview/>
                </div>
                <div v-else class="mx-auto w-16 mt-8 text-white">
                    <div class="text-center pt-4"><i class="pi pi-user"></i></div>
                </div>
            </div>
            <div class="basis-9/12 ml-4 pb-4">
                <!-- status + nummer -->
                <div class="float-right pr-2 mt-2">
                    <div class="flex rounded-full bg-gray-300 text-xs">
                        <div class="text-gray-500 px-2">{{ member.status }}&nbsp;&nbsp;&nbsp;</div>
                        <div class="text-center rounded-full bg-blue-900 text-white px-2 font-bold">
                            YK-{{ member.id }}
                        </div>
                    </div>
                    <div class="mt-2 text-right">
                        <group-renderer :member="member"/>
                    </div>
                </div>
                <div class="text-xl mt-2 font-bold">
                    {{ member.firstname }} {{ member.lastname }}
                </div>
                <div>
                    ° {{ moment(member.dateOfBirth).format("DD/MM/YYYY") }}
                    - {{ member.gender }}
                </div>
                <div class="mt-2 pr-8">
                    <div :style="'background-color: #'+member.grade.color"
                         class="rounded-full text-white px-2 font-bold text-center w-32 text-sm">
                        {{ member.grade.name }}
                    </div>
                </div>
                <div class="mt-2">
                    <div class="px-2 bg-sky-400 rounded-full text-white text-xs w-32 text-center">
                        {{ member.location.name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import type {Member} from "@/api/query/model";
import moment from "moment";
import GroupRenderer from "@/components/member/groupRenderer.vue";

const apiUrl = import.meta.env.VITE_API_URL;
const timestamp = new Date().getTime();

const props = defineProps<{
    member: Member,
}>();

</script>
