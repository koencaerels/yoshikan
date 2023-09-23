<?php

namespace App\YoshiKan\Application\Command\Member\MemberExtendSubscription;

trait member_extend_subscription
{
    public function memberExtendSubscription(\stdClass $jsonCommand): \stdClass
    {
        $command = MemberExtendSubscription::hydrateFromJson($jsonCommand);

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new MemberExtendSubscriptionHandler(
            $this->federationRepository,
            $this->locationRepository,
            $this->settingsRepository,
            $this->memberRepository,
            $this->subscriptionRepository,
            $this->entityManager,
        );

        $result = $handler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
