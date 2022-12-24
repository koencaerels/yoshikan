<?php

namespace App\YoshiKan\Application\Command\Member\ChangeSubscriptionStatus;

use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class ChangeSubscriptionStatusHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
    )
    {
    }

    public function go(ChangeSubscriptionStatus $command): bool
    {
        return true;
    }
}
