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

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionAsPayed;

use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsCanceled\MarkSubscriptionAsCanceled;
use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsCanceled\MarkSubscriptionAsCanceledHandler;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionPaymentType;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;

class MarkSubscriptionAsPayedHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected MemberRepository $memberRepository
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Handler
    // —————————————————————————————————————————————————————————————————————————

    public function go(MarkSubscriptionAsPayed $command): bool
    {
        $result = false;
        $subscription = $this->subscriptionRepository->getById($command->getId());

        if (SubscriptionStatus::AWAITING_PAYMENT === $subscription->getStatus()) {
            $subscription->changeStatus(SubscriptionStatus::PAYED);
            $subscription->setPaymentTypeInfo(SubscriptionPaymentType::TRANSFER);
            $this->subscriptionRepository->save($subscription);
            $result = true;
        }

        // mark the subscription and license as paid on the actual member
        if ($result && !is_null($subscription->getMember())) {
            $member = $subscription->getMember();
            if ($subscription->isMemberSubscriptionIsPartSubscription()) {
                $member->markSubscriptionAsPayed();
            }
            if ($subscription->isLicenseIsPartSubscription()) {
                $member->markLicenseAsPayed();
            }
            $this->memberRepository->save($member);
        }

        // cancel all other pending subscriptions for this member
        if ($result && !is_null($subscription->getMember())) {
            $cancelHandler = new MarkSubscriptionAsCanceledHandler($this->subscriptionRepository);
            $subscriptions = $this->subscriptionRepository->getByMember($subscription->getMember());
            foreach ($subscriptions as $subscription) {
                if ($subscription->getId() !== $command->getId()) {
                    $cancelCommand = MarkSubscriptionAsCanceled::make($subscription->getId());
                    $cancelHandler->go($cancelCommand);
                }
            }
        }

        return $result;
    }
}
