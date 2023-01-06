import axios from "axios";
import type {Member} from "@/api/query/model";

export async function getMemberById(id: number) {
    const response = await axios.get<Member>(`/member/${id}`);
    return response.data;
}
