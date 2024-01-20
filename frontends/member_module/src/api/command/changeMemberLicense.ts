/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface ChangeMemberLicenseCommand {
    memberId: number;
    federationId: number;
}

export async function changeMemberLicense(command: ChangeMemberLicenseCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response= await axios.post<boolean>(`/member/${command.memberId}/change-license`, formData);
    return response.data;
}
