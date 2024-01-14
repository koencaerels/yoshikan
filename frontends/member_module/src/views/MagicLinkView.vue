<template>

    <!-- loading -->
    <div v-if="status === 'loading'">
        <div id="background">
            <div class="mx-auto my-auto text-gray-400" style="width:50px;">
                <br><br><br>
                <ProgressSpinner/>
            </div>
        </div>
    </div>

    <!-- error -->
    <div v-if="status === 'error'">
        <div id="background">
            <div class="w-[35rem] bg-gray-100 p-4 rounded-xl flex gap-4" id="loginBox">
                <div>
                    <img src="../assets/lock.png" width="100">
                </div>
                <div>
                    <div class="text-sm">
                        Deze link om in te loggen is niet meer geldig.
                        <br>
                        <br>
                        <span @click="resendCode()"
                              class="underline underline-offset-4 text-blue-500 cursor-pointer">
                            Gelieve en nieuwe link aan te vragen.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup lang="ts">

import {onMounted, ref} from "vue";
import {useTwoFactorStore} from "@/store/twoFactor";
import {useAppStore} from "@/store/app";
import {useToast} from "primevue/usetoast";
import {useRouter} from "vue-router";

const props = defineProps<{ code: number; }>();
const twoFactorStore = useTwoFactorStore();
const appStore = useAppStore();
const toaster = useToast();
const router = useRouter();
const status = ref('loading');

onMounted((): void => {
    void checkCode();
});

async function checkCode() {
    twoFactorStore.accessCode = props.code;
    await twoFactorStore.verifyCode();
    console.log('Is link valid -> ' + twoFactorStore.isCodeValid);
    if (twoFactorStore.isCodeValid) {
        // -- redirect to the dashboard
        await router.push({name: 'dashboard'});
    } else {
        status.value = 'error';
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
    router.push({name: 'login'});
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
