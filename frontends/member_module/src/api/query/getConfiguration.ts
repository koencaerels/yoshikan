import axios from "axios";
import type {Configuration} from "@/api/query/model";

export async function getConfiguration() {
    const response = await axios.get<Configuration>(`/member/configuration`);
    return response.data;
}
