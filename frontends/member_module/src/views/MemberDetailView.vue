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
    <div id="MemberDetailView">
        <Splitter>
            <SplitterPanel :size="50">
                <div v-if="memberStore.isMemberLoading">
                    <div class="mx-auto my-auto text-gray-400" style="width:50px;">
                        <br><br><br>
                        <ProgressSpinner/>
                        <br><br><br>&nbsp;
                    </div>
                </div>
                <div v-else>
                    <div v-if="memberStore.memberDetail">
                        <member-detail :estate-height="370" type="detail"/>
                    </div>
                </div>
            </SplitterPanel>
            <SplitterPanel :size="50">
                <div v-if="memberStore.isMemberLoading">
                    <div class="mx-auto my-auto text-gray-400" style="width:50px;">
                        <br><br><br>
                        <ProgressSpinner/>
                        <br><br><br>&nbsp;
                    </div>
                </div>
                <div v-else>
                    <div v-if="memberStore.memberDetail">
                        <member-images/>
                    </div>
                </div>
            </SplitterPanel>
        </Splitter>
    </div>
</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import MemberImages from "@/components/member/memberImages.vue";
import MemberDetail from "@/components/member/memberDetail.vue";
import {onMounted} from "vue";

const props = defineProps<{ id: number; }>();
const memberStore = useMemberStore();

onMounted((): void => {
    if (memberStore.memberId === 0) {
        memberStore.loadMemberDetail(props.id);
    }
});

</script>
