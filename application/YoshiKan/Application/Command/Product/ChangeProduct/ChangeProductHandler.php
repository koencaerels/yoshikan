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

namespace App\YoshiKan\Application\Command\Product\ChangeProduct;

use App\YoshiKan\Domain\Model\Product\ProductRepository;

class ChangeProductHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected ProductRepository $productRepository
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Commands
    // —————————————————————————————————————————————————————————————————————————

    public function change(ChangeProduct $command): bool
    {
        $model = $this->productRepository->getById($command->getId());
        $model->change(
            $command->getCode(),
            $command->getName(),
        );
        $this->productRepository->save($model);

        return true;
    }
}
