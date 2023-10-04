/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface MarkSubscriptionAsCanceledCommand {
    id: number;
}

export async function markSubscriptionAsCanceled(command: MarkSubscriptionAsCanceledCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response = await axios.post<boolean>(`/subscription/${command.id}/cancel`, formData);
    return response.data;
}
