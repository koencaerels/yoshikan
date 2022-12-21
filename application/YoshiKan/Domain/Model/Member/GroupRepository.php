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

interface GroupRepository
{
    public function nextIdentity(): Uuid;

    public function save(Group $model): ?int;

    public function delete(Group $model): bool;

    public function getById(int $id): Group;

    public function getByUuid(Uuid $uuid): Group;

    public function getAll(): array;

    public function getMaxSequence(): int;
}
