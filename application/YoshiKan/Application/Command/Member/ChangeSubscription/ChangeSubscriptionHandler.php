<?php

namespace App\YoshiKan\Application\Command\Member\ChangeSubscription;

use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class ChangeSubscriptionHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected LocationRepository     $locationRepository,
        protected PeriodRepository       $periodRepository,
    )
    {
    }

    public function go(ChangeSubscription $command): bool
    {
        return true;
    }

}
