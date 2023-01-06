<template>
    <div id="dialogChangeDetails" style="width:600px;">
        change details
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {useMemberStore} from "@/store/member";

const appStore = useAppStore();
const memberStore = useMemberStore();

</script>
