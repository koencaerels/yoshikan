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

namespace App\YoshiKan\Application\Command\Product\ChangeProductItem;

use App\YoshiKan\Domain\Model\Product\ProductItemRepository;

class ChangeProductItemHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected ProductItemRepository $productItemRepository
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Commands
    // —————————————————————————————————————————————————————————————————————————

    public function change(ChangeProductItem $command): bool
    {
        $model = $this->productItemRepository->getById($command->getId());
        $model->change(
            code: $command->getCode(),
            name: $command->getName(),
            price: $command->getPrice(),
        );
        $this->productItemRepository->save($model);

        return true;
    }
}
