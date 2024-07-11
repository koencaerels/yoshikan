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

namespace App\YoshiKan\Domain\Model\TwoFactor;

use Bolt\Entity\User;
use Symfony\Component\Uid\Uuid;

interface MemberAccessCodeRepository
{
    public function nextIdentity(): Uuid;

    public function save(MemberAccessCode $model): int;

    public function delete(MemberAccessCode $model): bool;

    public function getById(int $id): MemberAccessCode;

    public function getByUuid(Uuid $uuid): MemberAccessCode;

    public function findByCode(string $code): ?MemberAccessCode;

    /**
     * @return MemberAccessCode[]
     */
    public function getByActiveUser(User $user): array;
}
