<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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
