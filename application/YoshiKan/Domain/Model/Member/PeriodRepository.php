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

interface PeriodRepository
{
    public function nextIdentity(): Uuid;

    public function save(Period $model): int;

    public function delete(Period $model): bool;

    public function getById(int $id): Period;

    public function getByUuid(Uuid $uuid): Period;

    public function getActive(): Period;

    public function getAll(): array;

    public function getMaxSequence(): int;
}
