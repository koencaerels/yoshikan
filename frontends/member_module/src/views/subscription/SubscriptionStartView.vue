<template>
    <div id="SubscriptionStartView">

        <Splitter>
            <SplitterPanel :size="50">
                <subscriptions-to-do/>
            </SplitterPanel>
            <SplitterPanel :size="50">
                <div v-if="memberStore.isLoading">
                    <div class="mx-auto my-auto text-gray-400" style="width:50px;">
                        <br><br><br>
                        <ProgressSpinner />
                    </div>
                </div>
                <div v-else>
                    <div v-if="memberStore.subscriptionDetail">
                        <subscription-detail/>
                    </div>
                </div>
            </SplitterPanel>
        </Splitter>

    </div>
</template>

<script setup lang="ts">
import SubscriptionsToDo from "@/components/subscription/subscriptionsToDo.vue";
import SubscriptionDetail from "@/components/subscription/subscriptionDetail.vue";
import {useMemberStore} from "@/store/member";

const memberStore = useMemberStore();

</script>
