<?php

namespace App\YoshiKan\Application\Command\Member\ChangeSubscription;

trait change_subscription
{
    public function changeSubscription(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeSubscription::hydrateFromJson($jsonCommand);
        $commandHandler = new ChangeSubscriptionHandler(
            $this->subscriptionRepository,
            $this->locationRepository
        );

        $result = $commandHandler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
