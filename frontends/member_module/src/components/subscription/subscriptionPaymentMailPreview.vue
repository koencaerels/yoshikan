<template>
    <div id="subscriptionPaymentMailPreview" style="width: 450px;">
        <div v-if="memberStore.subscriptionDetail" id="messageWrapper" class="text-sm">
            <p>naar: {{ memberStore.subscriptionDetail.contactEmail }}</p>
            <p>Dag {{ memberStore.subscriptionDetail.contactFirstname }},</p>
            <p>
                We hebben de inschrijving van
                <strong>{{ memberStore.subscriptionDetail.firstname }}
                    {{ memberStore.subscriptionDetail.lastname }}</strong>
                (° {{ moment(memberStore.subscriptionDetail.dateOfBirth).format("DD/MM/YYYY") }}
                - {{ memberStore.subscriptionDetail.gender }} )
                <span v-if="memberStore.subscriptionDetail.isNewMember">als nieuw lid</span>
                goed ontvangen en nagekeken.
            </p>
            <p>
                <strong>{{memberStore.subscriptionDetail.period.name}}</strong>
                <ul>
                    <li>Locatie: {{ memberStore.subscriptionDetail.location.name }}</li>
                    <li>
                        {{ memberStore.subscriptionDetail.type }},
                        <span v-if="memberStore.subscriptionDetail.numberOfTraining === 1">
                          1 training per week
                        </span>
                        <span v-else>
                           2 trainingen per week
                        </span>
                        <span>
                           = {{ memberStore.subscriptionFee }} €
                        </span>
                        <span v-if="memberStore.subscriptionDetail.isReductionFamily">
                          (met {{ memberStore.subscriptionDetail.settings.familyDiscount }}% gezinskorting)
                        </span>
                    </li>
                    <li v-if="memberStore.subscriptionDetail.isExtraTraining">
                        3 tot 5 trainingen per week = {{ memberStore.subscriptionDetail.settings.extraTrainingFee }} €
                    </li>
                    <li v-if="memberStore.subscriptionDetail.isNewMember">
                        Inschrijvingspakket: judogids, judopaspoort, leskaart + sportzak voor judopak
                        = {{ memberStore.subscriptionDetail.settings.newMemberSubscriptionFee }} €
                    </li>
                    <li v-if="memberStore.subscriptionDetail.isJudogiBelt && memberStore.subscriptionDetail.judogi">
                        Judopak + gordel (maat {{ memberStore.subscriptionDetail.judogi.name }})
                        = {{ memberStore.subscriptionDetail.judogiPrice }} €
                    </li>
                </ul>
            </p>
            <p v-if="memberStore.subscriptionDetail.remarks.length != 0">
                <span class="font-bold text-xs">Opmerkingen:</span>
                <br><span style="white-space: pre;">{{ memberStore.subscriptionDetail.remarks }}</span>
            </p>
            <p>
                <strong>Totaal: {{ memberStore.subscriptionDetail.total }} €</strong>
                <br>Gelieve bovenstaand bedrag over te schrijven
                <br>op rekeningnr. BE37 7330 0101 8328 (BIC KREDBEBB)
                <br>met als referentie: "YKS-{{ memberStore.subscriptionDetail.id }}
                {{ memberStore.subscriptionDetail.firstname }} {{ memberStore.subscriptionDetail.lastname }}".
                <br>Alvast bedankt.
            </p>
            <p>
                Met vriendelijke groeten,
                <br>Team Yoshi-Kan.
            </p>
        </div>

        <hr>
        <div class="flex flex-row mt-2">
            <div class="basis-1/4">&nbsp;</div>
            <div class="basis-1/2">
                <Button
                    @click="sendPaymentOverview"
                    v-if="!isSending"
                    class="p-button-success w-full"
                    icon="pi pi-envelope"
                    :label="buttonLabel"/>
                <Button
                    v-else
                    disabled
                    class="p-button-success w-full"
                    icon="pi pi-spinner pi-spin"
                    :label="buttonLabel"/>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import {useMemberStore} from "@/store/member";
import moment from "moment";
import {computed, ref} from "vue";
import {sendPaymentOverviewEmail} from "@/api/command/sendPaymentOverviewEmail";
import {useAppStore} from "@/store/app";
import {useToast} from "primevue/usetoast";

const memberStore = useMemberStore();
const isSending = ref<boolean>(false)
const emit = defineEmits(["send"]);
const toaster = useToast();
const appStore = useAppStore();

const buttonLabel = computed((): string => {
    let label = 'Verzend email';
    if (memberStore.subscriptionDetail && memberStore.subscriptionDetail.isPaymentOverviewSend) {
        label = 'Verzend email opnieuw';
    }
    return label;
});

async function sendPaymentOverview() {
    isSending.value = true;
    let result = await sendPaymentOverviewEmail(memberStore.subscriptionDetail?.id ?? 0);
    await memberStore.reloadSubscriptionDetail();
    isSending.value = false;
    toaster.add({
        severity: "success",
        summary: "Betalingsoverzicht verzonden.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    emit('send');
}

</script>

<style scoped>

#messageWrapper p {
    margin-bottom: 15px;
}

#messageWrapper ul {
    list-style: disc;
    margin-left: 20px;
}

</style>
