<?php

namespace App\YoshiKan\Application\Command\Member\OrderJudogi;

trait order_judogi
{
    public function orderJudogi(\stdClass $jsonCommand): bool
    {
        $command = OrderJudogi::hydrateFromJson($jsonCommand);

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new OrderJudogiHandler($this->judogiRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }

}
