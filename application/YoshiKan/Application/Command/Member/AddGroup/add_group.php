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

namespace App\YoshiKan\Application\Command\Member\AddGroup;

trait add_group
{
    public function addGroup(\stdClass $jsonCommand): bool
    {
        $command = AddGroup::hydrateFromJson($jsonCommand);

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new AddGroupHandler($this->groupRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
