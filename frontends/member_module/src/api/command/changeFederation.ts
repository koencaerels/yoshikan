/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface ChangeFederationCommand {
    id: number;
    code: string;
    name: string;
    yearlySubscriptionFee: string;
    publicLabel: string;
}

export async function changeFederation(command: ChangeFederationCommand) {
    const formData = new FormData();
    formData.append('federation', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/federation/${command.id}`, formData);
    return response.data;
}
