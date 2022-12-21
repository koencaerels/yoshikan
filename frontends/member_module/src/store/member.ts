/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {defineStore} from 'pinia'

export type MemberState = {}

export const useMemberStore = defineStore({
    id: "member",
    state: (): MemberState => ({}),
    actions: {},
    getters: {},
});
