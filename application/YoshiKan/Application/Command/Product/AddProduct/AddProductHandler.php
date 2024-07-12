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

namespace App\YoshiKan\Application\Command\Product\AddProduct;

use App\YoshiKan\Domain\Model\Product\Product;
use App\YoshiKan\Domain\Model\Product\ProductGroupRepository;
use App\YoshiKan\Domain\Model\Product\ProductRepository;

class AddProductHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected ProductRepository $productRepository,
        protected ProductGroupRepository $productGroupRepository,
    ) {
    }

    public function add(AddProduct $command): bool
    {
        $productGroup = $this->productGroupRepository->getById($command->getProductGroupId());
        $model = Product::make(
            uuid: $this->productRepository->nextIdentity(),
            productGroup: $productGroup,
            code: $command->getCode(),
            name: $command->getName(),
        );
        $this->productRepository->save($model);

        return true;
    }
}
