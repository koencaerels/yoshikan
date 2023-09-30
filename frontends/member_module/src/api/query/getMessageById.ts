/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";
import type {Message} from "@/api/query/model";

export async function getMessageById(id: number) {
    const response = await axios.get<Message>(`/message/${id}`);
    return response.data;
}
