<?php

namespace App\YoshiKan\Application\Command\Member\ChangeSubscriptionStatus;

trait change_subscription_status
{
    public function changeSubscriptionStatus(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeSubscriptionStatus::hydrateFromJson($jsonCommand);
        $commandHandler = new ChangeSubscriptionStatusHandler($this->subscriptionRepository);

        return $commandHandler->go($command);
    }
}
