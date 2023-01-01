<?php

namespace App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription;

use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class CreateMemberFromSubscriptionHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected MemberRepository       $memberRepository,
    ) {
    }
    public function go(CreateMemberFromSubscription $command): bool
    {
        return true;
    }
}
