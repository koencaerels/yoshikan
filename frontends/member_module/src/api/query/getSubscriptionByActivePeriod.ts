import axios from "axios";
import type {Subscription} from "@/api/query/model";

export async function getSubscriptionByActivePeriod() {
    const response = await axios.get<Subscription[]>(`/subscription/active-period`);
    return response.data;
}
