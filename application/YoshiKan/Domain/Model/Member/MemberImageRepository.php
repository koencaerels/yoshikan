<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use Symfony\Component\Uid\Uuid;

interface MemberImageRepository
{
    public function nextIdentity(): Uuid;

    public function save(MemberImage $model): int;

    public function delete(MemberImage $model): bool;

    public function getById(int $id): MemberImage;

    public function getByUuid(Uuid $uuid): MemberImage;
}
