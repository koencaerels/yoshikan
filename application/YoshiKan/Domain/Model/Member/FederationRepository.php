<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use Symfony\Component\Uid\Uuid;

interface FederationRepository
{
    public function nextIdentity(): Uuid;

    public function save(Federation $model): ?int;

    public function delete(Federation $model): bool;

    public function getById(int $id): Federation;

    public function getByUuid(Uuid $uuid): Federation;

    public function getAll(): array;
}
