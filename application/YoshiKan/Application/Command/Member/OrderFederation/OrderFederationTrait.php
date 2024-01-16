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

namespace App\YoshiKan\Application\Command\Member\OrderFederation;

trait OrderFederationTrait
{
    public function orderFederation(\stdClass $jsonCommand): bool
    {
        $command = OrderFederation::hydrateFromJson($jsonCommand);

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new OrderFederationHandler($this->federationRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
