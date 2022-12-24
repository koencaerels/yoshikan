import axios from "axios";
import type {Subscription} from "@/api/query/model";

export async function getSubscriptionTodo() {
    const response = await axios.get<Subscription[]>(`/subscription/todo`);
    return response.data;
}
