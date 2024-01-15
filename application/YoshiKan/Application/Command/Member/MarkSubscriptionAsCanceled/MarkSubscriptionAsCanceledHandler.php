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

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionAsCanceled;

use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;

class MarkSubscriptionAsCanceledHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected MemberRepository $memberRepository,
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

            $member = $subscription->getMember();
            if (false === is_null($member) && $command->isCancelMember()) {
                $member->deactivate();
                $this->memberRepository->save($member);
            }
        }

        return $result;
    }
}
