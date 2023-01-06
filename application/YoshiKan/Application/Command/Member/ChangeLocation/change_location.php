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

namespace App\YoshiKan\Application\Command\Member\ChangeLocation;

trait change_location
{
    public function changeLocation(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeLocation::hydrateFromJson($jsonCommand);
        $handler = new ChangeLocationHandler($this->locationRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
