<?php

namespace App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription;

trait create_member_from_subscription
{
    public function createMemberFromSubscription(int $id): bool
    {
        $command = new CreateMemberFromSubscription($id);
        $commandHandler = new CreateMemberFromSubscriptionHandler(
            $this->subscriptionRepository,
            $this->memberRepository,
            $this->gradeRepository
        );
        $result = $commandHandler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
