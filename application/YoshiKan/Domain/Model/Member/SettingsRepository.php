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

interface SettingsRepository
{
    public function nextIdentity(): Uuid;

    public function save(Settings $model): ?int;

    public function delete(Settings $model): bool;

    public function getById(int $id): Settings;

    public function getByUuid(Uuid $uuid): Settings;

    public function findByCode(string $code): ?Settings;

    public function getAll(): array;
}
