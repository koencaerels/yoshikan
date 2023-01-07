<template>
    <div id="memberList">
        <!-- -- search form ---------------------------------------------------- -->
        <div class="p-2 bg-gray-200 text-sm">
            <form v-on:submit.prevent>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Naam of lidnr.</div>
                    <div class="basis-2/3">
                        <InputText class="w-full p-inputtext-sm"
                                   placeholder="keyword"
                                   v-model="searchModel.keyword"/>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Locatie</div>
                    <div class="basis-2/3">
                        <Dropdown class="w-full" v-if="appStore.configuration"
                                  v-model="searchModel.locationId"
                                  :show-clear="true"
                                  placeholder="selecteer een locatie"
                                  option-label="name" option-value="id"
                                  :options="appStore.configuration.locations"/>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Graad</div>
                    <div class="basis-2/3">
                        <Dropdown class="w-full" v-if="appStore.configuration"
                                  :show-clear="true"
                                  v-model="searchModel.grade"
                                  placeholder="selecteer een graad"
                                  :options="appStore.configuration.grades">
                            <template #value="slotProps">
                                <div v-if="slotProps.value">
                                    <div class="text-white rounded-full text-sm px-3"
                                         :style="'background-color:#'+slotProps.value.color">
                                        {{ slotProps.value.name }}
                                    </div>
                                </div>
                                <div v-else>
                                    {{ slotProps.placeholder }}
                                </div>
                            </template>
                            <template #option="slotProps">
                                <div class="text-white rounded-full text-sm px-3"
                                     :style="'background-color:#'+slotProps.option.color">
                                    {{ slotProps.option.name }}
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Geboorte jaar</div>
                    <div class="basis-2/3">
                        <InputText class="w-full p-inputtext-sm"
                                   placeholder="geboorte jaar"
                                   v-model="searchModel.yearOfBirth"/>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-4/12">&nbsp;</div>
                    <div class="basis-1/2 mr-2 ml-3">
                        <Button v-if="!isSearching"
                                @click="searchMemberHandler"
                                label="Zoek in de leden" type="submit"
                                class="p-button-sm w-full" icon="pi pi-search"/>
                        <Button v-else
                                disabled
                                label="Zoek in de leden" type="submit"
                                class="p-button-sm w-full" icon="pi pi-spinner pi-spin"/>
                    </div>
                    <div class="basis-2/12">
                        <Button label="Reset"
                                @click="resetSearch"
                                class="p-button-sm w-full p-button-outlined" icon="pi pi-times"/>
                    </div>
                </div>
            </form>
        </div>

        <!-- -- member result list ---------------------------------------------------------  -->
        <div class="flex font-bold border-b-[1px] border-black mt-1 text-sm pb-1">
            <div class="w-8">&nbsp;</div>
            <div class="w-16 ml-2">Lidnr.</div>
            <div class="w-64 ml-2">Naam</div>
            <div class="w-36 ml-2">Geboortedatum</div>
            <div class="w-16 ml-2">Graad</div>
        </div>

        <list-wrapper :estate-height="375">
            <div v-for="member in members"
                 :class="selectedClass(member.id)"
                 class="border-b-[1px] border-gray-300">
                <div class="flex pt-1 pb-1">
                    <div class="w-8 pl-1">
                        <edit-button @click="loadMemberDetail(member.id)"/>
                    </div>
                    <div class="w-16 mt-1.5 ml-2">
                        <div class="text-center rounded-full bg-blue-900 text-white px-2 font-bold text-xs">
                            YK-{{ member.id }}
                        </div>
                    </div>
                    <div class="w-64 ml-2 font-bold">
                        {{ member.firstname }} {{ member.lastname }}
                    </div>
                    <div class="w-36 ml-2 text-sm mt-0.5">
                        ° {{ moment(member.dateOfBirth).format("DD/MM/YYYY") }}
                        - {{ member.gender }}
                    </div>
                    <div class="w-16 ml-2 mt-1">
                        <div class="text-white rounded-full text-xs px-2 text-center"
                             :style="'background-color:#'+member.grade.color">
                            {{ member.grade.name }}
                        </div>
                    </div>
                </div>
            </div>
        </list-wrapper>

    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import {computed, onMounted, ref, watch} from "vue";
import type {MemberSearchModel} from "@/api/query/searchMember";
import type {Member} from "@/api/query/model";
import {searchMembers} from "@/api/query/searchMember";
import ListWrapper from "@/components/wrapper/listWrapper.vue";
import moment from "moment";
import EditButton from "@/components/common/editButton.vue";
import {useMemberStore} from "@/store/member";

const memberStore = useMemberStore();
const appStore = useAppStore();
const searchModel = ref<MemberSearchModel>({
    keyword: '',
    locationId: undefined,
    grade: undefined,
    yearOfBirth: undefined,
});
const members = ref<Member[]>([]);
const isSearching = ref<boolean>(false);

onMounted(() => {
    searchMemberHandler();
});

const counter = computed((): number => memberStore.memberCounter);

watch(counter, (): void => {
    void searchMemberHandler();
});

function selectedClass(id: number) {
    let style = '';
    if (id === memberStore.memberId) {
        style = 'bg-blue-100';
    }
    return style;
}

async function searchMemberHandler() {
    isSearching.value = true;
    members.value = await searchMembers(searchModel.value);
    isSearching.value = false;
}

function resetSearch() {
    searchModel.value = {
        keyword: '',
        locationId: undefined,
        grade: undefined,
        yearOfBirth: undefined
    }
    searchMemberHandler();
}

async function loadMemberDetail(id: number) {
    await memberStore.loadMemberDetail(id);
}

</script>
