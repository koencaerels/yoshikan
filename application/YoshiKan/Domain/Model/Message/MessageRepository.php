<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Message;

use Symfony\Component\Uid\Uuid;

interface MessageRepository
{
    public function nextIdentity(): Uuid;

    public function save(Message $model): ?int;

    public function delete(Message $model): bool;

    public function getById(int $id): Message;

    public function getByUuid(Uuid $uuid): Message;
}
