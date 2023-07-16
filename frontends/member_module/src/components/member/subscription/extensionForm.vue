<template>
    <div style="width:800px;">
        Verlenging lidgeld en vergunning.
    </div>
</template>

<script setup lang="ts">
import type {Member} from "@/api/query/model";

const props = defineProps<{
    member: Member,
}>();

</script>
