<?php

namespace App\YoshiKan\Application\Command\Member\AddJudogi;

trait add_judogi
{

    public function addJudogi(\stdClass $jsonCommand): bool
    {
        $command = AddJudogi::hydrateFromJson($jsonCommand);
        $handler = new AddJudogiHandler($this->judogiRepository);
        $handler->go($command);

        $this->entityManager->flush();
        return true;
    }
}
