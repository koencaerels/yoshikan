<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Message;

use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Subscription;
use Symfony\Component\Uid\Uuid;

interface MessageRepository
{
    public function nextIdentity(): Uuid;

    public function save(Message $model): int;

    public function delete(Message $model): bool;

    public function getById(int $id): Message;

    public function getByUuid(Uuid $uuid): Message;

    public function getByMember(Member $member): array;

    public function getBySubscription(Subscription $subscription): array;
}
