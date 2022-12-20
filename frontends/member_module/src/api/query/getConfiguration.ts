import axios from "axios";
import type {Configuration} from "@/api/query/model";

export async function getConfiguration() {
    const response = await axios.get<Configuration>(`/configuration/`);
    return response.data;
}
