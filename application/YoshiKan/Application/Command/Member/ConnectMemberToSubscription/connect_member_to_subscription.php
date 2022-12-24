<?php

namespace App\YoshiKan\Application\Command\Member\ConnectMemberToSubscription;

trait connect_member_to_subscription
{
    public function connectMemberToSubscription(\stdClass $jsonCommand): bool
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
