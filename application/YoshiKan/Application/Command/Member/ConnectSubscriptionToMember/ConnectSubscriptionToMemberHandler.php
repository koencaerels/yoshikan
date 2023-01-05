<?php

namespace App\YoshiKan\Application\Command\Member\ConnectSubscriptionToMember;

use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class ConnectSubscriptionToMemberHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected MemberRepository       $memberRepository,
    ) {
    }

    public function go(ConnectSubscriptionToMember $command): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getId());
        $member = $this->memberRepository->getById($command->getMemberId());

        $subscription->setMember($member);

        return true;
    }
}