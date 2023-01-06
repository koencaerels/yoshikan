<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use Symfony\Component\Uid\Uuid;

interface GradeLogRepository
{

    public function nextIdentity(): Uuid;

    public function save(GradeLog $model): ?int;

    public function delete(GradeLog $model): bool;

    public function getById(int $id): GradeLog;

    public function getByUuid(Uuid $uuid): GradeLog;

}
