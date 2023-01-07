/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface OrderGroupCommand {
    sequence: Array<number>;
}

export async function orderGroup(command: OrderGroupCommand) {
    const formData = new FormData();
    formData.append('sequence', JSON.stringify(command));
    const response = await axios.post<boolean>('/member/group/order', formData);

    return response.data;
}
