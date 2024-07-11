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

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionAsPayedFromMollie;

use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsCanceled\MarkSubscriptionAsCanceled;
use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsCanceled\MarkSubscriptionAsCanceledHandler;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionPaymentType;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;

class MarkSubscriptionAsPayedFromMollieHandler
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

    public function go(MarkSubscriptionAsPayedFromMollie $command): ?int
    {
        $result = false;
        $subscription = $this->subscriptionRepository->findByPaymentId($command->getPaymentId());
        if (true === is_null($subscription)) {
            return 0;
        }

        if (SubscriptionStatus::AWAITING_PAYMENT === $subscription->getStatus()) {
            $subscription->changeStatus(SubscriptionStatus::PAYED);
            $subscription->setPaymentTypeInfo(SubscriptionPaymentType::MOLLIE);
            $this->subscriptionRepository->save($subscription);
            $result = true;
        }

        // -- mark the subscription and license as paid on the actual member ------------
        $member = $subscription->getMember();
        if ($result && !is_null($member)) {
            if ($subscription->isMemberSubscriptionIsPartSubscription()) {
                $member->markSubscriptionAsPayed();
            }
            if ($subscription->isLicenseIsPartSubscription()) {
                $member->markLicenseAsPayed();
            }
            $this->memberRepository->save($member);
        }

        // -- cancel all other pending subscriptions for this member --------------------
        if ($result && !is_null($member)) {
            $cancelHandler = new MarkSubscriptionAsCanceledHandler(
                subscriptionRepository: $this->subscriptionRepository,
                memberRepository: $this->memberRepository
            );
            $subscriptions = $this->subscriptionRepository->getByMember($member);
            foreach ($subscriptions as $subscriptionEntity) {
                if ($subscriptionEntity->getId() !== $subscription->getId()) {
                    $cancelCommand = MarkSubscriptionAsCanceled::make($subscription->getId(), false);
                    $cancelHandler->go($cancelCommand);
                }
            }
        }

        return $subscription->getId();
    }
}
