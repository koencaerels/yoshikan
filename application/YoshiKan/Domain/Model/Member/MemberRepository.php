<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use Symfony\Component\Uid\Uuid;

interface MemberRepository
{
    public function nextIdentity(): Uuid;

    public function save(Member $model): ?int;

    public function delete(Member $model): bool;

    public function getById(int $id): Member;

    public function getByUuid(Uuid $uuid): Member;
}
