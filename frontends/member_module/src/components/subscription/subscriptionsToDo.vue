<template>
    <div id="subscriptionsToDo">
        <div class="p-4 bg-gray-200 text-sm">
            <div class="flex flex-row">
                <div class="basis-1/3 text-right mr-2">Periode</div>
                <div class="basis-2/3">
                    <strong v-if="appStore.configuration">
                        {{ appStore.configuration.activePeriod.name }}
                    </strong>
                </div>
            </div>
            <div class="flex flex-row mt-2">
                <div class="basis-1/3 text-right mr-2 mt-1">Trefwoord</div>
                <div class="basis-2/3">
                    <InputText class="w-full p-inputtext-sm"
                               v-model="searchModel.keyword"/>
                </div>
            </div>
            <div class="flex flex-row mt-2">
                <div class="basis-1/3 text-right mr-2 mt-1">Status</div>
                <div class="basis-2/3">
                    <Dropdown class="w-full"
                              :show-clear="true"
                              v-model="searchModel.status"
                              :options="status"/>
                </div>
            </div>
            <div class="flex flex-row mt-2">
                <div class="basis-1/3 text-right mr-2 mt-1">Locatie</div>
                <div class="basis-2/3">
                    <Dropdown class="w-full" v-if="appStore.configuration"
                              :show-clear="true"
                              v-model="searchModel.locationId"
                              option-label="name" option-value="id"
                              :options="appStore.configuration.locations"/>
                </div>
            </div>
            <div class="flex flex-row mt-2">
                <div class="basis-1/2 text-right mr-2">
                    <Button class="p-button-sm p-button-secondary w-full"
                            icon="pi pi-plus" @click="addSubscription"
                            label="Nieuwe inschrijving"/>
                </div>
                <div class="basis-1/2 text-right">
                    <Button label="Filter" class="p-button-sm w-full" icon="pi pi-filter"/>
                </div>
            </div>
        </div>

        <!-- -- dialog new subscription -->
        <Dialog v-model:visible="showNewSubscription" position="topleft"
                :header="'Voeg een inschrijving toe voor '+appStore.configuration.activePeriod.name"
                :modal="true">
            <subscription-add/>
        </Dialog>

        <!-- list  -->
        <list-wrapper :estate-height="450">
            {{ searchModel }}
            <div v-for="i in 50">
                {{ i }}
            </div>
        </list-wrapper>

    </div>
</template>

<script setup lang="ts">
import ListWrapper from "@/components/wrapper/listWrapper.vue";
import {useAppStore} from "@/store/app";
import {ref} from "vue";
import SubscriptionAdd from "@/components/subscription/subscriptionAdd.vue";

const appStore = useAppStore();
const status = ['nieuw', 'wachtend op betaling', 'betaald'];
const searchModel = ref({
    keyword: '',
    locationId: null,
    status: null,
});
const showNewSubscription = ref<boolean>(false);

function addSubscription() {
    showNewSubscription.value = true;
}

</script>
