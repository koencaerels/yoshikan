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

namespace App\YoshiKan\Application\Command\Product\OrderProductItemBatch;

trait OrderProductItemBatchTrait
{
    /**
     * @throws \Exception
     */
    public function orderProductItemBatch(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = OrderJudogi::hydrateFromJson($jsonCommand);
        $handler = new OrderJudogiHandler($this->judogiRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
