<?php

namespace App\YoshiKan\Application\Command\Member\ConnectMemberToSubscription;

use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class ConnectMemberToSubscriptionHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected MemberRepository       $memberRepository,
    )
    {
    }

    public function go(ConnectMemberToSubscription $command): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getId());
        $member = $this->memberRepository->getById($command->getMemberId());


        return true;
    }
}
