<template>
    <div id="memberDetail" class="p-4" v-if="memberStore.memberDetail">

        <member-badge :member="memberStore.memberDetail"/>


    </div>
</template>

<script setup lang="ts">
import MemberBadge from "@/components/member/memberBadge.vue";
import {useMemberStore} from "@/store/member";

const memberStore = useMemberStore();

</script>

