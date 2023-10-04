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

namespace App\YoshiKan\Application\Query\Member;

use App\YoshiKan\Application\Query\Member\Readmodel\SubscriptionReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\SubscriptionReadModelCollection;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;

class GetSubscription
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected MemberRepository $memberRepository
    ) {
    }

    public function getById(int $id): SubscriptionReadModel
    {
        return SubscriptionReadModel::hydrateFromModel($this->subscriptionRepository->getById($id));
    }

    public function getByMemberId(int $memberId): SubscriptionReadModelCollection
    {
        $member = $this->memberRepository->getById($memberId);
        $subscriptions = $this->subscriptionRepository->getByMember($member);
        $collection = new SubscriptionReadModelCollection();
        foreach ($subscriptions as $subscription) {
            $collection->addItem(SubscriptionReadModel::hydrateFromModel($subscription));
        }

        return $collection;
    }

    public function getByStatus(SubscriptionStatus $status): SubscriptionReadModelCollection
    {
        $collection = new SubscriptionReadModelCollection();
        $subscriptions = $this->subscriptionRepository->getByStatus($status);
        $collection = new SubscriptionReadModelCollection();
        foreach ($subscriptions as $subscription) {
            $collection->addItem(SubscriptionReadModel::hydrateFromModel($subscription));
        }

        return $collection;
    }

    //    public function getSubscriptionTodos(): SubscriptionReadModelCollection
    //    {
    //        $activePeriod = $this->periodRepository->getActive();
    //        $subscriptions = $this->subscriptionRepository->getTodoByPeriod($activePeriod);
    //        $collection = new SubscriptionReadModelCollection([]);
    //        foreach ($subscriptions as $subscription) {
    //            $subscriptionRM = SubscriptionReadModel::hydrateFromModel($subscription);
    //            $collection->addItem($subscriptionRM);
    //        }
    //
    //        return $collection;
    //    }
    //
    //    public function getSubscriptionsByActivePeriod(): SubscriptionReadModelCollection
    //    {
    //        $activePeriod = $this->periodRepository->getActive();
    //        $subscriptions = $this->subscriptionRepository->getByPeriod($activePeriod);
    //        $collection = new SubscriptionReadModelCollection([]);
    //        foreach ($subscriptions as $subscription) {
    //            $subscriptionRM = SubscriptionReadModel::hydrateFromModel($subscription);
    //            $collection->addItem($subscriptionRM);
    //        }
    //
    //        return $collection;
    //    }
    //
    //    public function getAllSubscriptions(): SubscriptionReadModelCollection
    //    {
    //        $subscriptions = $this->subscriptionRepository->getAll();
    //        $collection = new SubscriptionReadModelCollection([]);
    //        foreach ($subscriptions as $subscription) {
    //            $subscriptionRM = SubscriptionReadModel::hydrateFromModel($subscription);
    //            $collection->addItem($subscriptionRM);
    //        }
    //
    //        return $collection;
    //    }
}
