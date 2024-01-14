<template>

    <div id="background">
        <div class="w-[35rem] bg-gray-100 p-4 rounded-xl flex gap-4" id="loginBox">
            <div>
                <img src="../assets/lock.png" width="100">
            </div>
            <div>
                <div class="text-sm">
                    We hebben je net een toegangscode gestuurd om in te loggen.
                </div>
                <div class="mt-4">
                    <form v-on:submit.prevent="login">
                        <div class="flex gap-4">
                            <div>
                                <InputText v-model="twoFactorStore.accessCode"
                                           type="text"
                                           class="w-full"
                                           maxlength="6"/>
                            </div>
                            <div>
                                <Button label="INLOGGEN"
                                        type="submit"
                                        class="w-full p-button-success"/>
                            </div>
                        </div>
                        <div v-if="error.length !== 0" class="mt-2 text-xs text-red-500">
                            {{ error }}
                        </div>
                    </form>
                </div>
                <div class="text-xs mt-4">
                    Heb je geen code ontvangen?
                    <span @click="resendCode()"
                          class="underline underline-offset-4 text-blue-500 cursor-pointer">
                        Verstuur code opnieuw.
                    </span>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup lang="ts">
import {useTwoFactorStore} from "@/store/twoFactor";
import {useAppStore} from "@/store/app";
import {useToast} from "primevue/usetoast";
import {useRouter} from "vue-router";
import {onMounted, ref} from "vue";


const twoFactorStore = useTwoFactorStore();
const appStore = useAppStore();
const toaster = useToast();
const router = useRouter();
const error = ref('');

onMounted((): void => {
    twoFactorStore.generatedAndSendCode();
});

async function login() {
    if (twoFactorStore.accessCode.length === 6) {
        await twoFactorStore.verifyCode();
        console.log('Is link valid? ' + twoFactorStore.isCodeValid);
        if (twoFactorStore.isCodeValid) {
            // -- redirect to the dashboard
            await router.push({name: 'dashboard'});
        } else {
            error.value = 'De ingegeven code is niet geldig.';
        }
    }
}

async function resendCode() {
    await twoFactorStore.generatedAndSendCode();
    toaster.add({
        severity: "success",
        summary: "Nieuwe code is verstuurd.",
        detail: "",
        life: appStore.toastLifeTime,
    });
    twoFactorStore.accessCode = '';
}

</script>

<style scoped>

#loginBox {
    box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.1),
    0px 3px 15px rgba(0, 0, 0, 0.1),
    0px 5px 30px rgba(0, 0, 0, 0.1),
    0px 8px 44px rgba(0, 0, 0, 0.1),
    0px 10px 59px rgba(0, 0, 0, 0.1),
    0px 13px 74px rgba(0, 0, 0, 0.1);
    margin-top: 120px;
    margin-left: 120px;
}

#background {
    position: fixed;
    top: 0;
    left: 67px;
    right: 0;
    bottom: 0;
    background-color: #A6B7C8;
}

</style>
