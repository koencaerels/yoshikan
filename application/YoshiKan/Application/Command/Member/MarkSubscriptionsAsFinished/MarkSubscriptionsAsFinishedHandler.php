<?php

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionsAsFinished;

use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;

class MarkSubscriptionsAsFinishedHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
    ) {
    }

    public function go(MarkSubscriptionsAsFinished $command): bool
    {
        foreach ($command->getListIds() as $id) {
            $subscription = $this->subscriptionRepository->getById($id);
            $subscription->changeStatus(SubscriptionStatus::COMPLETE);
            $this->subscriptionRepository->save($subscription);
        }

        return true;
    }
}
