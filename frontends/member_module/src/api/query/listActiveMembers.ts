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

export async function listActiveMembers(): Promise<Array<Member>> {
    const response = await axios.get<Array<Member>>(`/member/active`);
    return response.data;
}
