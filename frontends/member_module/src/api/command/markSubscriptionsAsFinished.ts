/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface MarkSubscriptionsAsFinishedCommand {
    listIds: Array<number>;
}

export async function markSubscriptionsAsFinished(command: MarkSubscriptionsAsFinishedCommand) {
    const formData = new FormData();
    formData.append('list-ids', JSON.stringify(command));
    const response = await axios.post<boolean>(`/subscription/mark-as-finished`, formData);
    return response.data;
}
