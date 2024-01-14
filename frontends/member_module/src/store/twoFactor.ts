/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {defineStore} from 'pinia'
import axios from "axios";

const isDevelopment = import.meta.env.DEV;

export type TwoFactorState = {
    isLoading: boolean;
    isCodeValid: boolean;
    accessCode: string;
}

export const useTwoFactorStore = defineStore({
    id: "twoFactor",
    state: (): TwoFactorState => ({
        isLoading: false,
        isCodeValid: false,
        accessCode: "",
    }),
    actions: {
        async generatedAndSendCode() {
            const response = await axios.get<boolean>('member/request-access');
        },
        async verifyCode() {
            if (this.accessCode === "123456" && isDevelopment) {
                this.isCodeValid = true;
            } else {
                const response = await axios.get<boolean>(`member/validate-access/${this.accessCode}`);
                this.isCodeValid = response.data;
            }
        }
    },
    getters: {},
});
