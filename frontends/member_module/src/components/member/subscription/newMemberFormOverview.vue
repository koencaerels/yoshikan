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
        new member form overview
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import type {Member} from "@/api/query/model";
import type {newMemberSubscriptionCommand} from "@/api/command/subscription/newMemberSubscription";

const props = defineProps<{
    member: Member,
    command: newMemberSubscriptionCommand
}>();

const appStore = useAppStore();

// ---------------------------------------------------------------------------------------------------------------------
// -- computed properties
// ---------------------------------------------------------------------------------------------------------------------

</script>

<style scoped>

</style>
