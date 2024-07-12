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

trait ChangeProductItemBatchTrait
{
    /**
     * @throws \Exception
     */
    public function changeProductItemBatch(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeProductItemBatch::hydrateFromJson($jsonCommand);
        $handler = new ChangeProductItemBatchHandler($this->productItemBatchRepository);
        $handler->change($command);
        $this->entityManager->flush();

        return true;
    }
}
