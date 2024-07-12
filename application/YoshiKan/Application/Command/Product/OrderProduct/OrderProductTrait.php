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

namespace App\YoshiKan\Application\Command\Product\OrderProduct;

trait OrderProductTrait
{
    /**
     * @throws \Exception
     */
    public function orderProduct(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = OrderProduct::hydrateFromJson($jsonCommand);
        $handler = new OrderProductHandler($this->productRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
