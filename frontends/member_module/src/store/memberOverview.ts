import {defineStore} from "pinia";
import {ref} from "vue";
import type {Member} from "@/api/query/model";
import {listActiveMembers} from "@/api/query/listActiveMembers";

export const useMemberOverviewStore = defineStore('memberOverview', () => {

    const members = ref<Array<Member>>([]);

    async function loadActiveMembers() {
        members.value = await listActiveMembers();
    }

    return {members, loadActiveMembers}

});
