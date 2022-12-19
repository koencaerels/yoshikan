<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use Symfony\Component\Uid\Uuid;

interface GroupRepository
{

    public function nextIdentity(): Uuid;

    public function save(Group $model): ?int;

    public function delete(Group $model): bool;

    public function getById(int $id): Group;

    public function getByUuid(Uuid $uuid): Group;

    public function getAll(): array;

}
