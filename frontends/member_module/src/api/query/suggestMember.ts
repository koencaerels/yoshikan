/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";
import type {Member} from "@/api/query/model";

export interface MemberSuggestModel {
    firstname: string,
    lastname: string;
    dateOfBirth?: Date,
}

export async function suggestMember(suggestModel: MemberSuggestModel) {
    const formData = new FormData();
    formData.append('suggest-model', JSON.stringify(suggestModel));
    const response = await axios.post<Member[]>(`/member/suggest`, formData);
    return response.data;
}
