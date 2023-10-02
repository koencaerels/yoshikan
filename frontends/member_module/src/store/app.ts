/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {defineStore} from 'pinia'
import type {Configuration} from "@/api/query/model";
import {getConfiguration} from "@/api/query/getConfiguration";
import type {DashboardNumbers} from "@/api/query/reportModel";
import {getDashboardNumbers} from "@/api/query/getDashboardNumbers";

export type AppState = {
    toastLifeTime: number;
    isLoading: boolean;
    isConfigurationLoaded: boolean;
    configuration?: Configuration;
    dashboardNumbers?: DashboardNumbers;
}

export const useAppStore = defineStore({
    id: "app",
    state: (): AppState => ({
        toastLifeTime: 3000,
        isLoading: false,
        isConfigurationLoaded: false,
        configuration: undefined,
        dashboardNumbers: undefined
    }),
    actions: {
        async loadConfiguration() {
            this.isLoading = true;
            this.configuration = await getConfiguration();
            this.dashboardNumbers = await getDashboardNumbers();
            this.isConfigurationLoaded = true;
            this.isLoading = false;
        },
    },
    getters: {},
});
