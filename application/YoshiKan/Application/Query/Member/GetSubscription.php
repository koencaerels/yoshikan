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

use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Query\SubscriptionReadModel;
use Query\SubscriptionReadModelCollection;

class GetSubscription
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected PeriodRepository $periodRepository
    ) {
    }

    public function getSubscriptionTodos(): SubscriptionReadModelCollection
    {
        $activePeriod = $this->periodRepository->getActive();
        $subscriptions = $this->subscriptionRepository->getTodoByPeriod($activePeriod);
        $collection = new SubscriptionReadModelCollection([]);
        foreach ($subscriptions as $subscription) {
            $subscriptionRM = SubscriptionReadModel::hydrateFromModel($subscription);
            $collection->addItem($subscriptionRM);
        }

        return $collection;
    }

    public function getSubscriptionsByActivePeriod(): SubscriptionReadModelCollection
    {
        $activePeriod = $this->periodRepository->getActive();
        $subscriptions = $this->subscriptionRepository->getByPeriod($activePeriod);
        $collection = new SubscriptionReadModelCollection([]);
        foreach ($subscriptions as $subscription) {
            $subscriptionRM = SubscriptionReadModel::hydrateFromModel($subscription);
            $collection->addItem($subscriptionRM);
        }

        return $collection;
    }

    public function getAllSubscriptions(): SubscriptionReadModelCollection
    {
        $subscriptions = $this->subscriptionRepository->getAll();
        $collection = new SubscriptionReadModelCollection([]);
        foreach ($subscriptions as $subscription) {
            $subscriptionRM = SubscriptionReadModel::hydrateFromModel($subscription);
            $collection->addItem($subscriptionRM);
        }

        return $collection;
    }

    public function getById(int $id): SubscriptionReadModel
    {
        return SubscriptionReadModel::hydrateFromModel($this->subscriptionRepository->getById($id));
    }
}
