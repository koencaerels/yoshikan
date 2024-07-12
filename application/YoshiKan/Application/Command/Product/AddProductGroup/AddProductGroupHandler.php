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

namespace App\YoshiKan\Application\Command\Product\AddProductGroup;

use App\YoshiKan\Domain\Model\Product\ProductGroup;
use App\YoshiKan\Domain\Model\Product\ProductGroupRepository;

class AddProductGroupHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected ProductGroupRepository $productGroupRepository,
    ) {
    }

    public function add(AddProductGroup $command): bool
    {
        $model = ProductGroup::make(
            uuid: $this->productGroupRepository->nextIdentity(),
            code: $command->getCode(),
            name: $command->getName(),
        );
        $this->productGroupRepository->save($model);

        return true;
    }
}
