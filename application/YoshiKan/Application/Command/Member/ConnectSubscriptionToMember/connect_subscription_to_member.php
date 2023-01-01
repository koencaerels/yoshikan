<?php

namespace App\YoshiKan\Application\Command\Member\ConnectSubscriptionToMember;

trait connect_subscription_to_member
{
    public function connectSubscriptionToMember(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ConnectMemberToSubscription::hydrateFromJson($jsonCommand);
        $commandHandler = new ConnectMemberToSubscriptionHandler(
            $this->subscriptionRepository,
            $this->memberRepository
        );

        return $commandHandler->go($command);
    }
}
