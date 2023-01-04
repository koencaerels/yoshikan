/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {defineStore} from 'pinia'
import type {Subscription} from "@/api/query/model";
import {getSubscriptionTodo} from "@/api/query/getSubscriptionTodo";
import {getSubscriptionById} from "@/api/query/getSubscriptionById";
import {getSubscriptionByActivePeriod} from "@/api/query/getSubscriptionByActivePeriod";
import {getSubscriptionAll} from "@/api/query/getSubscriptionAll";

export type MemberState = {
    isLoading: boolean;
    subscriptionTodos: Subscription[];
    subscriptionDetail?: Subscription;
    refreshCounter: number;
    subscriptionsActivePeriod: Subscription[];
    subscriptionsArchive: Subscription[];
}

export const useMemberStore = defineStore({
    id: "member",
    state: (): MemberState => ({
        isLoading: false,
        subscriptionTodos: [],
        subscriptionDetail: undefined,
        refreshCounter: 0,
        subscriptionsActivePeriod: [],
        subscriptionsArchive: []
    }),
    actions: {

        // -- subscription lists -------------------------------------------------

        async loadSubscriptionTodo() {
            this.subscriptionTodos = await getSubscriptionTodo();
        },
        async loadSubscriptionsByActivePeriod()
        {
            this.subscriptionsActivePeriod = await getSubscriptionByActivePeriod();
        },
        async loadSubscriptionsArchive()
        {
            this.subscriptionsArchive = await getSubscriptionAll();
        },

        // -- subscription detail ------------------------------------------------

        async loadSubscriptionDetail(id: number) {
            this.isLoading = true;
            this.subscriptionDetail = await getSubscriptionById(id);
            this.isLoading = false;
        },
        async reloadSubscriptionDetail() {
            if (this.subscriptionDetail) {
                this.subscriptionDetail = await getSubscriptionById(this.subscriptionDetail.id);
            }
        },
        increaseCounter() {
            this.refreshCounter++;
        },
    },
    getters: {
        subscriptionFee() {
            let fee = 0;
            if (this.subscriptionDetail) {
                if (this.subscriptionDetail.type === 'volledig jaar') {
                    if (this.subscriptionDetail.numberOfTraining === 1) {
                        fee = parseFloat(this.subscriptionDetail.settings.yearlyFee1Training);
                    } else {
                        fee = parseFloat(this.subscriptionDetail.settings.yearlyFee2Training);
                    }
                } else {
                    if (this.subscriptionDetail.numberOfTraining === 1) {
                        fee = parseFloat(this.subscriptionDetail.settings.halfYearlyFee1Training);
                    } else {
                        fee = parseFloat(this.subscriptionDetail.settings.halfYearlyFee2Training);
                    }
                }
                if (this.subscriptionDetail.isReductionFamily) {
                    let reduction = (parseFloat(this.subscriptionDetail.settings.familyDiscount) * fee) / 100;
                    fee = Math.ceil(fee - reduction);
                }
            }
            return fee;
        }
    },
});
