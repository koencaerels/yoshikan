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

namespace App\YoshiKan\Application\Command\Member\OrderLocation;

trait OrderLocationTrait
{
    public function orderLocation(\stdClass $jsonCommand): bool
    {
        $command = OrderLocation::hydrateFromJson($jsonCommand);

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new OrderLocationHandler($this->locationRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
