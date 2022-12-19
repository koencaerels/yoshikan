<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use Symfony\Component\Uid\Uuid;

interface SubscriptionRepository
{
    public function nextIdentity(): Uuid;

    public function save(Subscription $model): ?int;

    public function delete(Subscription $model): bool;

    public function getById(int $id): Subscription;

    public function getByUuid(Uuid $uuid): Subscription;

    public function getAll(): array;
}
