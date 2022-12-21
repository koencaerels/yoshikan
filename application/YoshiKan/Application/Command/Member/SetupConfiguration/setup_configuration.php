<?php

namespace App\YoshiKan\Application\Command\Member\SetupConfiguration;

trait setup_configuration
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
