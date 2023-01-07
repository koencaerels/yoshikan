/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface ChangeLocationCommand {
    id: number;
    code: string;
    name: string;
}

export async function changeLocation(command: ChangeLocationCommand) {
    const formData = new FormData();
    formData.append('location', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/location/${command.id}`, formData);
    return response.data;
}
