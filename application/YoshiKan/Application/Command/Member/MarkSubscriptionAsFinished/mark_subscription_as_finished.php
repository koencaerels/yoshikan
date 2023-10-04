<?php

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionAsFinished;

trait mark_subscription_as_finished
{
    /**
     * @throws \Exception
     */
    public function markSubscriptionAsFinished(\stdClass $jsonCommand): bool
    {
        $command = MarkSubscriptionAsFinished::hydrateFromJson($jsonCommand);

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new MarkSubscriptionAsFinishedHandler($this->subscriptionRepository);
        $result = $handler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
