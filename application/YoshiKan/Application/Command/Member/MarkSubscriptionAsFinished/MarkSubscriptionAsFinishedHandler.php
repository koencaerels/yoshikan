<?php

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionAsFinished;

use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;

class MarkSubscriptionAsFinishedHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected SubscriptionRepository $subscriptionRepository
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Handler
    // —————————————————————————————————————————————————————————————————————————
    public function go(MarkSubscriptionAsFinished $command): bool
    {
        $result = false;
        $subscription = $this->subscriptionRepository->getById($command->getId());

        if (SubscriptionStatus::PAYED === $subscription->getStatus()) {
            $subscription->changeStatus(SubscriptionStatus::COMPLETE);
            $this->subscriptionRepository->save($subscription);
            $result = true;
        }

        return $result;
    }
}
