<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use Symfony\Component\Uid\Uuid;

interface LocationRepository
{
    public function nextIdentity(): Uuid;

    public function save(Location $model): ?int;

    public function delete(Location $model): bool;

    public function getById(int $id): Location;

    public function getByUuid(Uuid $uuid): Location;

    public function getAll(): array;
}
