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

namespace App\YoshiKan\Application\Command\Member\ChangeSubscriptionStatus;

use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class ChangeSubscriptionStatusHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
    ) {
    }

    public function go(ChangeSubscriptionStatus $command): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getId());
        $subscription->changeStatus($command->getStatus());
        $this->subscriptionRepository->save($subscription);

        return true;
    }
}
