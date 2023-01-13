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
                        <member-detail :is-detail="true"/>
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
