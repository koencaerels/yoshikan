/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";
export interface AddGroupCommand {
    code: string;
    name: string;
    minAge: string;
    maxAge: string;
}

export async function addGroup(command: AddGroupCommand) {
    const formData = new FormData();
    formData.append('group', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/group/add`, formData);
    return response.data;
}
