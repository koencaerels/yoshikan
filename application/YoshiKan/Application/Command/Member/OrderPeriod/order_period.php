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

namespace App\YoshiKan\Application\Command\Member\OrderPeriod;

trait order_period
{
    public function orderPeriod(\stdClass $jsonCommand): bool
    {
        $command = OrderPeriod::hydrateFromJson($jsonCommand);

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new OrderPeriodHandler($this->periodRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
