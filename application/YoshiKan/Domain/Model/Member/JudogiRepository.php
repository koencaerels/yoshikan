<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use Symfony\Component\Uid\Uuid;

interface JudogiRepository
{
    public function nextIdentity(): Uuid;

    public function save(Judogi $model): ?int;

    public function delete(Judogi $model): bool;

    public function getById(int $id): Judogi;

    public function getByUuid(Uuid $uuid): Judogi;

    public function getAll(): array;
}
