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

namespace App\YoshiKan\Application\Query\Product;

use App\YoshiKan\Application\Query\Product\Readmodel\ProductGroupReadModel;
use App\YoshiKan\Application\Query\Product\Readmodel\ProductGroupReadModelCollection;
use App\YoshiKan\Domain\Model\Product\ProductGroupRepository;

class GetProduct
{
    public function __construct(protected ProductGroupRepository $productGroupRepository)
    {
    }

    public function getProductTree(): ProductGroupReadModelCollection
    {
        $result = new ProductGroupReadModelCollection([]);
        $groups = $this->productGroupRepository->getAll();
        foreach ($groups as $group) {
            $result->addItem(ProductGroupReadModel::hydrateFromModel($group));
        }

        return $result;
    }
}
