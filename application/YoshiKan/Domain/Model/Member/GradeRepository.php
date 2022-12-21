<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use Symfony\Component\Uid\Uuid;

interface GradeRepository
{
    public function nextIdentity(): Uuid;

    public function save(Grade $model): ?int;

    public function delete(Grade $model): bool;

    public function getById(int $id): Grade;

    public function getByUuid(Uuid $uuid): Grade;

    public function getAll(): array;

    public function getMaxSequence(): int;
}
