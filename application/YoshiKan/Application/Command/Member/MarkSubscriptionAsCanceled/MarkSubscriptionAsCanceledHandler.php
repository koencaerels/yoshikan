<?php

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionAsCanceled;

use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;

class MarkSubscriptionAsCanceledHandler
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

    public function go(MarkSubscriptionAsCanceled $command): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getId());
        $result = false;

        if (SubscriptionStatus::NEW === $subscription->getStatus()
            || SubscriptionStatus::AWAITING_PAYMENT === $subscription->getStatus()) {
            $subscription->changeStatus(SubscriptionStatus::CANCELED);
            $this->subscriptionRepository->save($subscription);
            $result = true;
        }

        return $result;
    }
}
