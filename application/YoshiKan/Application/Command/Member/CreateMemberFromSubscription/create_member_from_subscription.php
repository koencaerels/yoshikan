<?php

namespace App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription;

trait create_member_from_subscription
{
    public function createMemberFromSubscription(int $id): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

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
