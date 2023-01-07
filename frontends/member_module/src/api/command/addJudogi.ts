/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface AddJudogiCommand {
    code: string;
    name: string;
    size: string;
    price: string;
}

export async function addJudogi(command: AddJudogiCommand) {
    const formData = new FormData();
    formData.append('judogi', JSON.stringify(command));
    const response = await axios.post<boolean>('/member/judogi/add', formData);
    return response.data;
}
