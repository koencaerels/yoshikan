/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface AddProductItemCommand {
    code: string;
    name: string;
    price: number;
    productId: number;
}

export async function addProductItem(command: AddProductItemCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response = await axios.post<boolean>('/product/item/add/', formData);
    return response.data;
}
