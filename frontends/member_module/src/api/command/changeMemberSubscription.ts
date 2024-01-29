/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface ChangeMemberSubscriptionCommand {
    memberId: number;
    federationId: number;
    membershipStart: Date;
    membershipEnd: Date;
    licenseStart: Date;
    licenseEnd: Date;
    memberShipIsHalfYear: boolean;
    numberOfTraining: number;
}

export async function changeMemberSubscription(command: ChangeMemberSubscriptionCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/${command.memberId}/change-subscription`, formData);
    return response.data;
}
