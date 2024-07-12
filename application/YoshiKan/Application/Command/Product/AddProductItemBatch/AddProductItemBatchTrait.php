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

trait AddProductItemBatchTrait
{
    public function addProductItemBatch(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = AddProductItemBatch::hydrateFromJson($jsonCommand);
        $handler = new AddProductItemBatchHandler(
            $this->productItemRepository,
            $this->productItemBatchRepository,
        );
        $handler->add($command);

        $this->entityManager->flush();

        return true;
    }
}
