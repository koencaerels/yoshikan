<?php

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionsAsFinished;

trait mark_subscriptions_as_finished
{
    public function markSubscriptionAsFinished(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = MarkSubscriptionsAsFinished::hydrateFromJson($jsonCommand);
        $commandHandler = new MarkSubscriptionsAsFinishedHandler($this->subscriptionRepository);
        $result = $commandHandler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
