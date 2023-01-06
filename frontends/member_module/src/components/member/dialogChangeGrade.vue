<template>
    <div id="dialogChangeGrade" style="width:400px;">

        <div>
            <Dropdown class="w-full" v-if="appStore.configuration"
                      v-model="selectedGrade"
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

        <div class="mt-4">
            <Button label="Bewaar nieuwe graad"
                    icon="pi pi-save"
                    class="p-button-success p-button-sm w-full"/>
        </div>

    </div>
</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import {useAppStore} from "@/store/app";
import type {Grade} from "@/api/query/model";
import {ref} from "vue";

const appStore = useAppStore();
const memberStore = useMemberStore();
const selectedGrade = ref<Grade>(memberStore.memberDetail?.grade ?? {id: 0, code: '', color: '', name: '', uuid: ''});

</script>
