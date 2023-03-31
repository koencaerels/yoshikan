<?php

namespace App\YoshiKan\Application\Command\Member\OrderFederation;

trait order_federation
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
