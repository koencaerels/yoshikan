<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\YoshiKan\Application\Command\Member\ChangeFederation;

trait ChangeFederationTrait
{
    public function changeFederation(\stdClass $jsonCommand): bool
    {
        $command = ChangeFederation::hydrateFromJson($jsonCommand);

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new ChangeFederationHandler($this->federationRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
