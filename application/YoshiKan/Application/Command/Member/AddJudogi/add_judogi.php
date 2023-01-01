<?php

namespace App\YoshiKan\Application\Command\Member\AddJudogi;

trait add_judogi
{
    public function addJudogi(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = AddJudogi::hydrateFromJson($jsonCommand);
        $handler = new AddJudogiHandler($this->judogiRepository);
        $handler->go($command);

        $this->entityManager->flush();
        return true;
    }
}
