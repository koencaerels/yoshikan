/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface AddFederationCommand {
    code: string;
    name: string;
    yearlySubscriptionFee: string;
    publicLabel: string;
}

export async function addFederation(command: AddFederationCommand) {
    const formData = new FormData();
    formData.append('federation', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/federation/add`, formData);
    return response.data;
}
