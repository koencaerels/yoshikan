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

trait AddProductTrait
{
    /**
     * @throws \Exception
     */
    public function addProduct(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = AddProduct::hydrateFromJson($jsonCommand);
        $handler = new AddProductHandler(
            $this->productRepository,
            $this->productGroupRepository
        );
        $handler->add($command);

        $this->entityManager->flush();

        return true;
    }
}
