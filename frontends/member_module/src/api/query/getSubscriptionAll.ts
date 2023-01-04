import axios from "axios";
import type {Subscription} from "@/api/query/model";

export async function getSubscriptionAll() {
    const response = await axios.get<Subscription[]>(`/subscription/all`);
    return response.data;
}
