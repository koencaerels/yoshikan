/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";
import type {Subscription} from "@/api/query/model";

export async function getSubscriptionById(id: number) {
    const response = await axios.get<Subscription>(`/subscription/${id}`);
    return response.data;
}
