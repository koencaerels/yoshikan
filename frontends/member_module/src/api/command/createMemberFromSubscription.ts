/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export async function createMemberFromSubscription(id: number) {
    const response = await axios.post<boolean>(`/subscription/${id}/create-member`);
    return response.data;
}
