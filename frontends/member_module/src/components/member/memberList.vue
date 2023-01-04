<template>
    <div id="memberList">
        <!-- search form -->
        <div class="p-2 bg-gray-200 text-sm">

            <form v-on:submit.prevent>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Naam of code</div>
                    <div class="basis-2/3">
                        <InputText class="w-full p-inputtext-sm"/>
                    </div>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="basis-1/3 text-right mr-2 mt-1">Locatie</div>
                    <div class="basis-2/3">
                        <Dropdown class="w-full" v-if="appStore.configuration"
                                  :show-clear="true"
                                  option-label="name" option-value="id"
                                  :options="appStore.configuration.locations"/>
                    </div>
                </div>
            </form>
        </div>

        <!-- list result -->


    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";

const appStore = useAppStore();
</script>
