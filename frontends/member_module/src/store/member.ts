/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {defineStore} from 'pinia'
import type {Member, Message, Subscription} from "@/api/query/model";
import {getSubscriptionById} from "@/api/query/getSubscriptionById";
import {getMemberById} from "@/api/query/getMemberById";
import {getMemberMessages} from "@/api/query/getMemberMessages";
import {getMemberSubscriptions} from "@/api/query/getMemberSubscriptions";
import {getMessageById} from "@/api/query/getMessageById";

export type MemberState = {

    // -- subscription
    isLoading: boolean;
    subscriptionId: number;
    subscriptionDetail?: Subscription;
    refreshCounter: number;

    // -- member
    isMemberLoading: boolean;
    memberId: number;
    memberDetail?: Member;
    memberCounter: number;
    memberMessages: Array<Message>;
    memberSubscriptions: Array<Subscription>;

    // -- message
    isMessageLoading: boolean;
    messageId: number;
    messageDetail?: Message;
    messageCounter: number;
}

export const useMemberStore = defineStore({
    id: "member",
    state: (): MemberState => ({

        // -- subscription
        isLoading: false,
        subscriptionId: 0,
        subscriptionDetail: undefined,
        refreshCounter: 0,

        // -- member
        isMemberLoading: false,
        memberId: 0,
        memberDetail: undefined,
        memberCounter: 0,
        memberMessages: [],
        memberSubscriptions: [],

        // -- message
        isMessageLoading: false,
        messageId: 0,
        messageDetail: undefined,
        messageCounter: 0

    }),
    actions: {

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

        // -- member detail -------------------------------------------------------

        async loadMemberDetail(id: number) {
            this.memberId = id;
            this.isMemberLoading = true;
            this.memberDetail = await getMemberById(id);
            this.memberMessages = await getMemberMessages(id);
            this.memberSubscriptions = await getMemberSubscriptions(id);
            this.isMemberLoading = false;
        },
        async reloadMemberDetail() {
            if (this.memberId != 0) {
                this.memberDetail = await getMemberById(this.memberId);
                this.memberMessages = await getMemberMessages(this.memberId);
                this.memberSubscriptions = await getMemberSubscriptions(this.memberId);
            }
        },
        increaseMemberCounter() {
            this.memberCounter++;
        },

        // -- message detail -----------------------------------------------------

        async loadMessageDetail(id: number) {
            this.isMessageLoading = true;
            this.messageDetail = await getMessageById(id);
            this.isMessageLoading = false;
        },
        async reloadMessageDetail() {
            if (this.messageDetail) {
                this.messageDetail = await getMessageById(this.messageDetail.id);
            }
        },
        increaseMessageCounter() {
            this.messageCounter++;
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

                // todo new member fee...

                if (this.subscriptionDetail.isReductionFamily) {
                    let reduction = (parseFloat(this.subscriptionDetail.settings.familyDiscount) * fee) / 100;
                    fee = Math.ceil(fee - reduction);
                }
            }
            return fee;
        }
    },
});
