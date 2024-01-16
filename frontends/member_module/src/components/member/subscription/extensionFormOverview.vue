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
    <div id="extensionOverview" class="text-sm">

        <div class="text-right">
            Heist op den Berg, {{ currentFormattedDate }} ,
        </div>
        <div class="mt-4 italic">
            Betreft:
            <span v-if="command.type=== SubscriptionTypeEnum.RENEWAL_MEMBERSHIP">Vernieuwing lidmaatschap</span>
            <span v-if="command.type=== SubscriptionTypeEnum.RENEWAL_LICENSE">Vernieuwing vergunning</span>
            <span v-if="command.type=== SubscriptionTypeEnum.RENEWAL_FULL">Vernieuwing lidmaatschap + vergunning</span>
            &mdash; <span class="uppercase">{{ props.command.lastname }}</span>
            <span>&nbsp;{{ props.command.firstname }}</span>.
        </div>
        <div class="mt-4">
            <br>Beste {{ props.command.contactFirstname }} {{ props.command.contactLastname }}
            ({{ props.command.contactEmail }}),
        </div>

        <div class="mt-4">
            <span v-if="command.type==='hernieuwing_lidmaatschap'">Het lidmaatschap</span>
            <span v-if="command.type==='hernieuwing_vergunning'">De vergunning</span>
            <span v-if="command.type==='volledige_hernieuwing'">Het lidmaatschap en de vergunning</span>
            is verlopen of staat op het punt binnenkort te verlopen.
            Als <span class="uppercase font-bold">{{ props.command.lastname }}</span>
            <span class="font-bold">&nbsp;{{ props.command.firstname }}</span>
            lid wil blijven van onze judoclub voor het komende <span v-if="props.command.memberSubscriptionIsHalfYear">half </span>
            jaar, verzoeken wij je vriendelijk om een bedrag van
            <span class="font-bold">{{ props.command.total }} €</span>
            over te maken naar het volgende bankrekeningnummer:
            <span class="font-bold">BE37 7330 0101 8328</span>
            met vermelding van de referentie
            <span class="font-bold"> "YKS-xxx
            {{ props.command.lastname }} {{ props.command.firstname }}".</span>

            <br><br>Of betaal online via deze Mollie-link:
            <a href="#" class="text-blue-500">https://paymentlink.mollie.com/payment/xxxxx/</a>.

            <br><br>Als {{ props.command.firstname }} niet langer lid wenst te zijn, geef dan ons een seintje.
            Alvast bedankt.
        </div>

        <div class="mt-2">
            Mocht je nog vragen hebben of extra informatie nodig hebben, aarzel dan niet om contact
            met ons op te nemen via <strong>judo.yoshikan@gmail.com</strong>.
            Ons team staat altijd klaar om je te helpen.
        </div>

        <div class="mt-4 border-t-[1px] w-[750px] border-black mt-2 pt-2">
            <div>
                <span class="uppercase">{{ props.command.lastname }}</span>
                {{ props.command.firstname }} (°{{ formattedDateOfBirth }} &mdash;
                {{ props.command.gender }})
            </div>
            <div class="text-xs mt-2">
                <span>
                    {{ props.member.addressStreet }}
                    {{ props.member.addressNumber }}
                    <span v-if="props.member.addressBox != ''">bus {{ props.member.addressBox }}</span>
                </span>
                &mdash;
                <span>
                    {{ props.member.addressZip }}
                    {{ props.member.addressCity }}
                </span>
            </div>
        </div>
        <div class="mt-4">
            <div>
                &mdash; Lidgeld:
                van {{ memberSubscriptionStartMM }}/{{ memberSubscriptionStartYY }}
                <span class="font-bold"> tot {{ memberSubscriptionEndMM }}/{{ memberSubscriptionEndYY }}</span>
                <span v-if="props.command.memberSubscriptionIsPartSubscription">
                    :
                    <span v-if="props.command.numberOfTraining === 1">1 training per week</span>
                    <span v-else-if="props.command.numberOfTraining === 2">2 trainingen per week</span>
                    <span v-else-if="props.command.numberOfTraining === 3">3 tot 5 trainingen per week</span>
                    = {{ props.command.memberSubscriptionTotal }} €
                    <span v-if="props.command.isReductionFamily">
                        (met gezinskorting)
                    </span>
                </span>
                <span v-else>
                    <span v-if="props.command.memberSubscriptionIsPayed">
                        (betaald)
                    </span>
                </span>
            </div>
            <div>
                &mdash; Vergunning:
                van {{ licenseStartMM }}/{{ licenseStartYY }}
                <span class="font-bold"> tot {{ licenseEndMM }}/{{ licenseEndYY }}</span>
                <span v-if="props.command.licenseIsPartSubscription">
                    : {{ federationName }} = {{ props.command.licenseTotal }} €
                </span>
                <span v-else>
                    <span v-if="props.command.licenseIsPayed">
                        (betaald)
                    </span>
                </span>
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
import type {Member} from "@/api/query/model";
import type {MemberExtendSubscriptionCommand} from "@/api/command/subscription/memberExtendSubscription";
import {computed} from "vue";
import moment from "moment";
import OverviewFooter from "@/components/member/subscription/overviewFooter.vue";
import {SubscriptionTypeEnum} from "@/api/query/enum";

const props = defineProps<{
    member: Member,
    command: MemberExtendSubscriptionCommand
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
