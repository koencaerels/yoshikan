/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface ForgetMemberCommand {
    id: number;
}

export async function forgetMember(command: ForgetMemberCommand) {
    const formData = new FormData();
    formData.append('connect-member', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/${command.id}/forget`, formData);
    return response.data;
}
