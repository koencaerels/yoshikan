/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface ChangeSubscriptionStatusCommand {
    id: number;
    status: string;
}

export async function changeSubscriptionStatus(command: ChangeSubscriptionStatusCommand) {
    const formData = new FormData();
    formData.append('change-status', JSON.stringify(command));
    const response = await axios.post<boolean>(`/subscription/${command.id}/change-status`, formData);
    return response.data;
}
