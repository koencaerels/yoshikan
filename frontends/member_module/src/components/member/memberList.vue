<template>
    <div id="memberList">
        <!-- -- search form ---------------------------------------------------- -->
        <div class="p-2 bg-gray-200 text-sm">
            <form v-on:submit.prevent>

                <!-- status -->
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Status</div>
                    <div class="basis-2/3 text-xs">
                        <SelectButton v-model="searchModel.isActive"
                                      :options="statusOptions"
                                      option-value="value"
                                      optionLabel="name"/>
                    </div>
                </div>

                <!-- keyword -->
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Naam of lidnr.</div>
                    <div class="basis-2/3 text-xs">
                        <InputText class="w-full p-inputtext-lg"
                                   placeholder="keyword"
                                   v-model="searchModel.keyword"/>
                    </div>
                </div>

                <!-- locatie -->
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Locatie</div>
                    <div class="basis-2/3 text-xs">
                        <Dropdown class="w-full" v-if="appStore.configuration"
                                  v-model="searchModel.locationId"
                                  :show-clear="true"
                                  placeholder="selecteer een locatie"
                                  option-label="name" option-value="id"
                                  :options="appStore.configuration.locations"/>
                    </div>
                </div>

                <!-- filter on group -->
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Group</div>
                    <div class="basis-2/3 text-xs">
                        <Dropdown class="w-full" v-if="appStore.configuration"
                                  :show-clear="true"
                                  v-model="searchModel.group"
                                  placeholder="selecteer een groep"
                                  :options="appStore.configuration.groups">
                            <template #value="slotProps">
                                <div v-if="slotProps.value">
                                    <div class="text-white rounded-full text-sm px-3 bg-sky-400">
                                        {{ slotProps.value.name }}
                                    </div>
                                </div>
                                <div v-else>
                                    {{ slotProps.placeholder }}
                                </div>
                            </template>
                            <template #option="slotProps">
                                <div class="text-white rounded-full text-sm px-3 bg-sky-400">
                                    {{ slotProps.option.name }}
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- graad -->
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Graad</div>
                    <div class="basis-2/3 text-xs">
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

                <!-- geboorte jaar -->
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Geboorte jaar</div>
                    <div class="basis-2/3 text-xs">
                        <InputText class="w-full p-inputtext-sm"
                                   placeholder="geboorte jaar"
                                   v-model="searchModel.yearOfBirth"/>
                    </div>
                </div>

                <!-- buttons -->
                <div class="flex flex-row mt-2">
                    <div class="basis-4/12">
                        <div class="flex ml-2 mt-2">
                            <div class="cursor-pointer">
                                <font-awesome-icon icon="fa-solid fa-toggle-off"
                                                   @click="isCompactView = true"
                                                   v-if="!isCompactView"/>
                                <font-awesome-icon icon="fa-solid fa-toggle-on"
                                                   @click="isCompactView = false"
                                                   v-if="isCompactView"/>
                            </div>
                            <div class="ml-2 text-xs mt-0.5 cursor-pointer">
                                <div @click="isCompactView = true" v-if="!isCompactView">Compacte weergave?</div>
                                <div @click="isCompactView = false" v-if="isCompactView">Compacte weergave?</div>
                            </div>
                        </div>
                    </div>
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
        <div class="flex font-bold border-b-[1px] border-black mt-1 text-sm pb-1 gap-2">
            <div class="flex-none w-8">&nbsp;</div>
            <div class="flex-none w-16">Lidnr.</div>
            <div class="line-clamp-1 grow">Naam</div>
            <div class="flex-none w-[6rem]" v-if="isCompactView">Geboortedatum</div>
            <div class="flex-none w-32 text-center" v-if="!isCompactView">Groep / Locatie</div>
            <div class="flex-none w-[6rem] text-center" v-if="isCompactView">Groep</div>
            <div class="flex-none w-16  text-center">Graad</div>
        </div>

        <list-wrapper :estate-height="390">

            <div v-for="member in members" v-if="isCompactView"
                 :class="selectedClass(member.id)"
                 @click="loadMemberDetail(member.id)"
                 class="border-b-[1px] border-gray-400 flex py-1 cursor-pointer hover:bg-indigo-50 gap-2">

                <div class="flex-none text-xs w-[1rem] text-gray-300 ml-2">
                    <font-awesome-icon icon="fa-solid fa-pen"/>
                </div>
                <div class="flex-none w-24">
                    <div class="text-center rounded-full bg-blue-900 text-white px-2 font-bold text-xs w-[5rem]">
                        YK-{{ member.id }}
                    </div>
                </div>
                <div class="w-auto grow flex gap-1">
                    <div class="font-bold text-sm line-clamp-1">
                        <span class="uppercase">{{ member.lastname }}</span>
                        {{ member.firstname }}
                    </div>
                </div>
                <div v-if="member.status == 'actief'">
                    <img src="../../assets/active.png" width="18" class="mx-auto">
                </div>
                <div class="flex-none w-[6rem] text-sm">
                    <div class="text-xs">
                        ° {{ moment(member.dateOfBirth).format("DD/MM/YYYY") }}
                        - {{ member.gender }}
                    </div>
                </div>
                <div class="flex-none w-[6rem] text-sm">
                    <group-renderer :member="member"/>
                </div>
                <div class="flex-none w-16 pr-2">
                    <div class="text-white rounded-full text-xs px-2 text-center"
                         :style="'background-color:#'+member.grade.color">
                        {{ member.grade.name }}
                    </div>
                </div>
            </div>

            <div v-for="member in members" v-if="!isCompactView"
                 :class="selectedClass(member.id)"
                 class="border-b-[1px] border-gray-400">
                <div class="flex pt-1 pb-1 gap-2">
                    <div class="flex-none w-8 pl-2">
                        <edit-button @click="loadMemberDetail(member.id)"/>
                    </div>
                    <div class="flex-none w-24 mt-1.5">
                        <div class="text-center rounded-full bg-blue-900 text-white px-2 font-bold text-xs w-[5rem]">
                            YK-{{ member.id }}
                        </div>
                    </div>
                    <div class="grow">
                        <div class="font-bold">
                            <span class="uppercase">{{ member.lastname }}</span>
                            {{ member.firstname }}
                        </div>
                        <div class="text-xs">
                            ° {{ moment(member.dateOfBirth).format("DD/MM/YYYY") }}
                            - {{ member.gender }}
                        </div>
                    </div>
                    <div class="flex-none w-32 text-sm mt-0.5">
                        <div class="px-2 bg-sky-400 rounded-full text-white text-xs w-32 text-center">
                            {{ member.location.name }}
                        </div>
                        <div class="mt-1">
                            <group-renderer :member="member"/>
                        </div>
                    </div>
                    <div class="flex-none w-16 mt-1">
                        <div class="text-white rounded-full text-xs px-2 text-center mr-2"
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
import {searchMembers} from "@/api/query/searchMember";
import type {Member} from "@/api/query/model";
import ListWrapper from "@/components/wrapper/listWrapper.vue";
import moment from "moment";
import EditButton from "@/components/common/editButton.vue";
import {useMemberStore} from "@/store/member";
import GroupRenderer from "@/components/member/groupRenderer.vue";

const memberStore = useMemberStore();
const appStore = useAppStore();
const isCompactView = ref<boolean>(true);
const searchModel = ref<MemberSearchModel>({
    keyword: '',
    locationId: undefined,
    grade: undefined,
    yearOfBirth: undefined,
    group: undefined,
    isActive: undefined,
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

const statusOptions = ref([
    {name: 'niet van toepassing', value: undefined},
    {name: 'Actief', value: true},
    {name: 'Archief', value: false,}
]);

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
        yearOfBirth: undefined,
        group: undefined,
        isActive: undefined,
    }
    searchMemberHandler();
}

async function loadMemberDetail(id: number) {
    await memberStore.loadMemberDetail(id);
}

</script>
