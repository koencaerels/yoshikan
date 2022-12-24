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

export type MemberState = {
    isLoading: boolean;
    subscriptionTodos: Subscription[];
    subscriptionDetail?: Subscription;
}

export const useMemberStore = defineStore({
    id: "member",
    state: (): MemberState => ({
        isLoading: false,
        subscriptionTodos: [],
        subscriptionDetail: undefined,
    }),
    actions: {
        async loadSubscriptionTodo() {
            this.subscriptionTodos = await getSubscriptionTodo()
        },
        async loadSubscriptionDetail(id: number) {
            this.isLoading = true;
            this.subscriptionDetail = await getSubscriptionById(id);
            this.isLoading = false;
        }
    },
    getters: {},
});
