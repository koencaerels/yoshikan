import axios from "axios";
import type {Subscription} from "@/api/query/model";

export async function getSubscriptionById(id: number) {
    const response = await axios.get<Subscription>(`/subscription/${id}`);
    return response.data;
}
