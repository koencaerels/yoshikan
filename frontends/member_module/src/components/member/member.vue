<template>
    <div id="member">
        <Splitter>
            <SplitterPanel :size="50">
                <member-list/>
            </SplitterPanel>
            <SplitterPanel :size="50">
                <member-detail/>
            </SplitterPanel>
        </Splitter>
    </div>
</template>

<script setup lang="ts">
import MemberList from "@/components/member/memberList.vue";
import MemberDetail from "@/components/member/memberDetail.vue";

</script>
