<?php

namespace App\YoshiKan\Application\Command\Member\ChangeJudogi;

trait change_judogi
{
    public function changeJudogi(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeJudogi::hydrateFromJson($jsonCommand);
        $handler = new ChangeJudogiHandler($this->judogiRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
