<template>
    <div id="groupRenderer">
        <div v-if="group !== '' && member.status === 'actief' "
             class="w-24 bg-sky-400 text-white text-xs rounded-full text-center">
            {{group}}
        </div>
    </div>
</template>

<script setup lang="ts">
import type {Member} from "@/api/query/model";
import {useAppStore} from "@/store/app";
import moment from "moment";
import {computed} from "vue";

const props = defineProps<{
    member: Member,
}>();

const appStore = useAppStore();

const age = computed((): number => {
    let yearOfBirth = parseInt(moment(props.member.dateOfBirth).format('y'));
    let startSeason = parseInt(moment(appStore.configuration?.activePeriod.startDate ?? new Date()).format('y'));
    let age = startSeason - yearOfBirth;
    return age;
});

const group = computed( ():string => {
    if(appStore.configuration) {
        for (const group of appStore.configuration.groups) {
            if (age.value >= parseInt(group.minAge)
                && age.value <= parseInt(group.maxAge) ) {
                return group.name;
            }
        }
    }
    return '';
});

</script>
