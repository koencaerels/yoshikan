<template>
    <div id="member">
        <Splitter>
            <SplitterPanel :size="50">
                <member-list/>
            </SplitterPanel>
            <SplitterPanel :size="50">
                <div v-if="memberStore.isMemberLoading">
                    <div class="mx-auto my-auto text-gray-400" style="width:50px;">
                        <br><br><br>
                        <ProgressSpinner />
                    </div>
                </div>
                <div v-else>
                    <div v-if="memberStore.memberDetail">
                        <member-detail/>
                    </div>
                </div>
            </SplitterPanel>
        </Splitter>
    </div>
</template>

<script setup lang="ts">
import MemberList from "@/components/member/memberList.vue";
import MemberDetail from "@/components/member/memberDetail.vue";
import {useMemberStore} from "@/store/member";

const memberStore = useMemberStore();

</script>
