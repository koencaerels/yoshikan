<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use Symfony\Component\Uid\Uuid;

interface PeriodRepository
{
    public function nextIdentity(): Uuid;

    public function save(Period $model): ?int;

    public function delete(Period $model): bool;

    public function getById(int $id): Period;

    public function getByUuid(Uuid $uuid): Period;

    public function getAll(): array;
}
