<?php

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionsAsFinished;

use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class MarkSubscriptionsAsFinishedHandler
{

    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
    )
    {
    }

    public function go(MarkSubscriptionsAsFinished $command): bool
    {

        return true;
    }

}
