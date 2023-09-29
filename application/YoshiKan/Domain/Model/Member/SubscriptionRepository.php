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

    public function getByListId(array $list): array;

    public function getByDuePaymentByLocation(Location $location): array;

    public function getMaxId(): int;
}
