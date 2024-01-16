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

namespace App\YoshiKan\Application\Command\Member\SetupConfiguration;

trait SetupConfigurationTrait
{
    public function setupConfiguration(): bool
    {
        $command = new SetupConfiguration('YOSHIKAN');

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new SetupConfigurationHandler($this->periodRepository, $this->settingsRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
