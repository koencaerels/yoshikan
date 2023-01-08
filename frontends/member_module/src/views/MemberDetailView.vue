<template>
    <div id="MemberDetailView">
        <Splitter>
            <SplitterPanel :size="50">
                <div v-if="memberStore.isMemberLoading">
                    <div class="mx-auto my-auto text-gray-400" style="width:50px;">
                        <br><br><br>
                        <ProgressSpinner />
                    </div>
                </div>
                <div v-else>
                    <div v-if="memberStore.memberDetail">
                        <member-detail :is-detail="true"/>
                    </div>
                </div>
            </SplitterPanel>
            <SplitterPanel :size="50">
                <member-images/>
            </SplitterPanel>
        </Splitter>
    </div>
</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import MemberImages from "@/components/member/memberImages.vue";
import MemberDetail from "@/components/member/memberDetail.vue";

const memberStore = useMemberStore();
</script>
