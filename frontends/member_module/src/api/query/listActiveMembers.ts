import axios from "axios";
import type {Member} from "@/api/query/model";

export async function listActiveMembers(): Promise<Array<Member>> {
    const response = await axios.get<Array<Member>>(`/member/active`);
    return response.data;
}
