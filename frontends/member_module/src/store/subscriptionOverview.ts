import {defineStore} from "pinia";
import {ref} from "vue";
import type {Subscription} from "@/api/query/model";
import {getSubscriptionsNew} from "@/api/query/getSubscriptionsNew";
import {getSubscriptionsDuePayment} from "@/api/query/getSubscriptionsDuePayment";
import {getSubscriptionsPaid} from "@/api/query/getSubscriptionsPaid";
import {getSubscriptionsComplete} from "@/api/query/getSubscriptionsComplete";

export const useSubscriptionOverviewStore = defineStore('subscriptionOverview', () => {

    const subscriptionsNew = ref<Array<Subscription>>([]);
    const subscriptionsDuePayment = ref<Array<Subscription>>([]);
    const subscriptionsArchive = ref<Array<Subscription>>([]);
    const isLoading = ref<boolean>(false);

    async function loadSubscriptions() {
        isLoading.value = true;
        subscriptionsNew.value = await getSubscriptionsNew();
        subscriptionsDuePayment.value = await getSubscriptionsDuePayment();
        const subscriptionsPaid = await getSubscriptionsPaid();
        const subscriptionsComplete = await getSubscriptionsComplete();
        subscriptionsArchive.value = [...subscriptionsPaid, ...subscriptionsComplete];
        isLoading.value = false;
    }

    return {subscriptionsNew, subscriptionsDuePayment, subscriptionsArchive, loadSubscriptions}

});
