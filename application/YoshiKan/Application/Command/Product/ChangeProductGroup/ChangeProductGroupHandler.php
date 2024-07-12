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

namespace App\YoshiKan\Application\Command\Product\ChangeProductGroup;

use App\YoshiKan\Domain\Model\Product\ProductGroupRepository;

class ChangeProductGroupHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected ProductGroupRepository $productGroupRepository
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Commands
    // —————————————————————————————————————————————————————————————————————————

    public function change(ChangeProductGroup $command): bool
    {
        $model = $this->productGroupRepository->getById($command->getId());
        $model->change(
            $command->getCode(),
            $command->getName(),
        );
        $this->productGroupRepository->save($model);

        return true;
    }
}
