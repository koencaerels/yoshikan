<template>
    <div class="p-4">
        <div class="flex flex-row">
            <div class="basis-1/3 mt-2">
                Jaarlijks tarief 2 trainingen
            </div>
            <div class="basis-1/6">
                <InputText class="p-inputtext-sm w-full"></InputText>
            </div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Jaarlijks tarief 1 training
            </div>
            <div class="basis-1/6">
                <InputText class="p-inputtext-sm w-full"></InputText>
            </div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Half-jaarlijks tarief 2 trainingen
            </div>
            <div class="basis-1/6">
                <InputText class="p-inputtext-sm w-full"></InputText>
            </div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Half-jaarlijks tarief 1 training
            </div>
            <div class="basis-1/6">
                <InputText class="p-inputtext-sm w-full"></InputText>
            </div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Bijdrage 3 tot 5 trainingen
            </div>
            <div class="basis-1/6">
                <InputText class="p-inputtext-sm w-full"></InputText>
            </div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Nieuw leden pakket
            </div>
            <div class="basis-1/6">
                <InputText class="p-inputtext-sm w-full"></InputText>
            </div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
                Korting andere gezinsleden
            </div>
            <div class="basis-1/6">
                <InputText class="p-inputtext-sm w-full"></InputText>
            </div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="basis-1/3 mt-2">
              &nbsp;
            </div>
            <div class="basis-1/6">
                <Button label="Bewaar" icon="pi pi-save" class="w-full p-button-success p-button-sm"/>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";

const appStore = useAppStore();
</script>
