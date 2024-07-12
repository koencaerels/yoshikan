<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\YoshiKan\Application\Command\Product\AddProductItem;

use App\YoshiKan\Domain\Model\Product\ProductItem;
use App\YoshiKan\Domain\Model\Product\ProductItemRepository;
use App\YoshiKan\Domain\Model\Product\ProductRepository;

class AddProductItemHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected ProductItemRepository $productItemRepository,
        protected ProductRepository $productRepository,
    ) {
    }

    public function add(AddProductItem $command): bool
    {
        $product = $this->productRepository->getById($command->getProductId());
        $model = ProductItem::make(
            uuid: $this->productRepository->nextIdentity(),
            product: $product,
            code: $command->getCode(),
            name: $command->getName(),
            price: $command->getPrice(),
        );
        $this->productItemRepository->save($model);

        return true;
    }
}
