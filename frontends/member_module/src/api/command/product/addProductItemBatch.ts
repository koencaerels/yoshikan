/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface AddProductItemBatchCommand {
    code: string;
    name: string;
    cost: number;
    stock: number;
    productItemId: number;
}

export async function addProductItemBatch(command: AddProductItemBatchCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response = await axios.post<boolean>('/product/item/batch/add/', formData);
    return response.data;
}
