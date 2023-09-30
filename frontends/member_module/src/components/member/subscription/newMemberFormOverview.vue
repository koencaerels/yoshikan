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
    <div class="text-sm">
        <div class="text-right">
            Heist op den Berg, {{ currentFormattedDate }},
        </div>
        <div class="mt-2">
            <br>Beste {{ props.command.contactFirstname }} {{ props.command.contactLastname }}
            ({{ props.command.contactEmail }}),
        </div>
        <div class="mt-2">
            <p>
                Welkom {{ props.command.firstname }} {{ props.command.lastname }},
                bij Yoshi-Kan, de plek waar judo-liefhebbers samenkomen om hun passie voor deze prachtige sport
                te delen. <br>We zijn verheugd dat je ervoor hebt gekozen om deel uit te maken van onze judo familie!
            </p>
            <p class="mt-2">
                Om de inschrijving definitief te maken en ervoor te zorgen dat je volop kunt genieten van onze
                judolessen, verzoeken wij je vriendelijk om een bedrag van
                <span class="font-bold">{{ props.command.total }} €</span> over te maken
                naar onze bankrekening op het volgende nummer:
                <span class="font-bold">BE37 7330 0101 8328</span>
                met vermelding van volgende referentie
                <span class="font-bold"> "YKS-xxx
            {{ props.command.lastname }} {{ props.command.firstname }}".</span>
                Zo kunnen we je betaling snel identificeren.
                Wanneer we je betaling hebben ontvangen, zullen we je officieel inschrijven
                en krijg je toegang tot al onze trainingen en evenementen.
                We staan te popelen om je te verwelkomen op de mat.
            </p>
            <p class="mt-2">
                Mocht je nog vragen hebben of extra informatie nodig hebben, aarzel dan niet om contact
                met ons op te nemen via <strong>judo.yoshikan@gmail.com</strong>.
                Ons team staat altijd klaar om je te helpen.
            </p>
        </div>
        <div class="mt-4 border-t-[1px] w-[750px] border-black mt-2 pt-2">
            <div>
                <span class="uppercase">{{ props.command.lastname }}</span>
                {{ props.command.firstname }} (°{{ formattedDateOfBirth }} &mdash;
                {{ props.command.gender }})
            </div>
            <div class="text-xs mt-2">
                <span>
                    {{ props.command.addressStreet }}
                    {{ props.command.addressNumber }}
                    <span v-if="props.command.addressBox != ''">bus {{ props.command.addressBox }}</span>
                </span>
                &mdash;
                <span>
                    {{ props.command.addressZip }}
                    {{ props.command.addressCity }}
                </span>
            </div>
        </div>
        <div class="mt-4">
            <div>
                &mdash; Lidgeld :
                van {{ memberSubscriptionStartMM }}/{{ memberSubscriptionStartYY }}
                <span class="font-bold"> tot {{ memberSubscriptionEndMM }}/{{ memberSubscriptionEndYY }}</span>
                <span>
                    :
                    <span v-if="props.command.numberOfTraining === 1">1 training per week</span>
                    <span v-else-if="props.command.numberOfTraining === 2">2 trainingen per week</span>
                    <span v-else-if="props.command.numberOfTraining === 3">3 tot 5 trainingen per week</span>
                    + Inschrijvingspakket
                    = {{ props.command.memberSubscriptionTotal }} €
                    <span v-if="props.command.isReductionFamily">
                        (met gezinskorting)
                    </span>
                </span>
            </div>
            <div>
                &mdash; Vergunning:
                van {{ licenseStartMM }}/{{ licenseStartYY }}
                <span class="font-bold"> tot {{ licenseEndMM }}/{{ licenseEndYY }}</span>
                <span>: {{ federationName }} = {{ props.command.licenseTotal }} €</span>
            </div>
            <div class="border-b-[1px] w-[750px] border-black mt-2 pb-2">
                Totaal: {{ props.command.total }} €
            </div>
        </div>
        <div class="mt-4" v-if="props.command.remarks.length !== 0">
            {{ props.command.remarks }}
        </div>
        <div class="mt-4">
            Met sportieve groeten,
            <br>Team Yoshi-Kan
        </div>

        <overview-footer/>
    </div>
</template>

<script setup lang="ts">
import {useAppStore} from "@/store/app";
import type {NewMemberSubscriptionCommand} from "@/api/command/subscription/newMemberSubscription";
import {computed} from "vue";
import moment from "moment/moment";
import OverviewFooter from "@/components/member/subscription/overviewFooter.vue";

const props = defineProps<{
    command: NewMemberSubscriptionCommand
}>();

const appStore = useAppStore();

// ---------------------------------------------------------------------------------------------------------------------
// -- computed properties
// ---------------------------------------------------------------------------------------------------------------------

const currentFormattedDate = computed((): string => {
    return moment(new Date()).format("DD/MM/YYYY");
});

const formattedDateOfBirth = computed((): string => {
    return moment(props.command.dateOfBirth).format("DD/MM/YYYY");
});

const memberSubscriptionStartMM = computed((): string => {
    return moment(props.command.memberSubscriptionStart).format("MM")
});

const memberSubscriptionStartYY = computed((): string => {
    return moment(props.command.memberSubscriptionStart).format("YYYY")
});

const memberSubscriptionEndMM = computed((): string => {
    return moment(props.command.memberSubscriptionEnd).format("MM")
});

const memberSubscriptionEndYY = computed((): string => {
    return moment(props.command.memberSubscriptionEnd).format("YYYY")
});

const licenseStartMM = computed((): string => {
    return moment(props.command.licenseStart).format("MM")
});

const licenseStartYY = computed((): string => {
    return moment(props.command.licenseStart).format("YYYY")
});

const licenseEndMM = computed((): string => {
    return moment(props.command.licenseEnd).format("MM")
});

const licenseEndYY = computed((): string => {
    return moment(props.command.licenseEnd).format("YYYY")
});

const federationName = computed((): string => {
    if (appStore.configuration?.federations) {
        for (const federation of appStore.configuration.federations) {
            if (federation.id === props.command.federationId) {
                return federation.name.toUpperCase();
            }
        }
    }
    return '';
});

</script>

<style scoped>

</style>
