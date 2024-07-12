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

namespace App\YoshiKan\Application\Command\Product\AddProductItemBatch;

use App\YoshiKan\Domain\Model\Product\ProductItemBatch;
use App\YoshiKan\Domain\Model\Product\ProductItemBatchRepository;
use App\YoshiKan\Domain\Model\Product\ProductItemRepository;

class AddProductItemBatchHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected ProductItemRepository $productItemRepository,
        protected ProductItemBatchRepository $productItemBatchRepository,
    ) {
    }

    public function add(AddProductItemBatch $command): bool
    {
        $productItem = $this->productItemRepository->getById($command->getProductItemId());

        $model = ProductItemBatch::make(
            uuid: $this->productItemBatchRepository->nextIdentity(),
            productItem: $productItem,
            code: $command->getCode(),
            name: $command->getName(),
            stock: $command->getStock(),
            cost: $command->getCost(),
        );

        $this->productItemBatchRepository->save($model);

        return true;
    }
}
