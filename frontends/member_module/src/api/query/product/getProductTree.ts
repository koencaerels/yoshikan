/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";
import type {ProductGroup} from "@/api/query/product/model";

export async function getProductTree() {
    const response = await axios.get<ProductGroup[]>(`/products`);
    return response.data;
}
