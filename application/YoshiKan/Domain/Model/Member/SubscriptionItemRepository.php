<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use Symfony\Component\Uid\Uuid;

interface SubscriptionItemRepository
{
    public function nextIdentity(): Uuid;

    public function save(SubscriptionItem $model): ?int;

    public function delete(SubscriptionItem $model): bool;

    public function getById(int $id): SubscriptionItem;

    public function getByUuid(Uuid $uuid): SubscriptionItem;

    public function getBySubscription(Subscription $subscription): array;
}
