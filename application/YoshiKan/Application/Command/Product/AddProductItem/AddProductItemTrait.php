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

trait AddProductItemTrait
{
    /**
     * @throws \Exception
     */
    public function addProductItem(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = AddProductItem::hydrateFromJson($jsonCommand);
        $handler = new AddProductItemHandler(
            productItemRepository: $this->productItemRepository,
            productRepository: $this->productRepository,
        );
        $handler->add($command);

        $this->entityManager->flush();

        return true;
    }
}