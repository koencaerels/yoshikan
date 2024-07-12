import {defineStore} from "pinia";

export type ProductState = {
    isLoading: boolean;
}

export const useProductStore = defineStore({
    id: "product",
    state: (): ProductState => ({
        isLoading: false,
    }),
    actions: {},
    getters: {},
});
