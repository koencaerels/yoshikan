/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface ChangeProductCommand {
    id: number;
    code: string;
    name: string;
}

export async function changeProduct(command: ChangeProductCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response = await axios.post<boolean>(`/product/${command.id}`, formData);
    return response.data;
}
