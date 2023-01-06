import axios from "axios";
import type {Grade, Member} from "@/api/query/model";
export interface MemberSearchModel {
    keyword: string,
    locationId?: number,
    grade?: Grade,
    yearOfBirth?: string,
}

export async function searchMembers(searchModel: MemberSearchModel) {
    const formData = new FormData();
    formData.append('search-model', JSON.stringify(searchModel));
    const response = await axios.post<Member[]>(`/member/search`, formData);
    return response.data;
}
