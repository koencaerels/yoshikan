<?php

namespace App\YoshiKan\Application\Command\Member\ChangeSubscriptionStatus;

use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class ChangeSubscriptionStatusHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
    ) {
    }

    public function go(ChangeSubscriptionStatus $command): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getId());
        $subscription->changeStatus($command->getStatus());
        $this->subscriptionRepository->save($subscription);

        return true;
    }
}
