/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

export interface ProductGroup {
    id: number;
    uuid: string;
    code: string;
    name: string;
    products: Product[];
}

export interface Product {
    id: number;
    uuid: string;
    code: string;
    name: string;
    productItems: ProductItem[];
}

export interface ProductItem {
    id: number;
    uuid: string;
    name: string;
    price: number;
    productItemBatches: ProductItemBatch[];
}

export interface ProductItemBatch {
    id: number;
    uuid: string;
    name: string;
    stock: number;
    cost: number;
}
