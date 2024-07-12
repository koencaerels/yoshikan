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

namespace App\YoshiKan\Application\Command\Product\ChangeProductItemBatch;

use App\YoshiKan\Domain\Model\Product\ProductItemBatchRepository;

class ChangeProductItemBatchHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected ProductItemBatchRepository $productItemBatchRepository
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Commands
    // —————————————————————————————————————————————————————————————————————————

    public function change(ChangeProductItemBatch $command): bool
    {
        $model = $this->productItemBatchRepository->getById($command->getId());
        $model->change(
            code: $command->getCode(),
            name: $command->getName(),
            cost: $command->getCost(),
        );
        $this->productItemBatchRepository->save($model);

        return true;
    }
}
