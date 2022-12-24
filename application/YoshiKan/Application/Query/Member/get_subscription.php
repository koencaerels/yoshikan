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

trait get_subscription
{
    public function getTodoSubscription(): array
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);
        $query = new GetSubscription($this->subscriptionRepository, $this->periodRepository);
        return $query->getSubscriptionTodos()->getCollection();
    }

    public function getSubscriptionById(int $id): SubscriptionReadModel
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);
        $query = new GetSubscription($this->subscriptionRepository, $this->periodRepository);
        return $query->getById($id);
    }
}
