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

interface MemberRepository
{
    public function nextIdentity(): Uuid;

    public function save(Member $model): ?int;

    public function delete(Member $model): bool;

    public function getById(int $id): Member;

    public function getByUuid(Uuid $uuid): Member;

    public function findByNameAndDateOfBirth(string $firstname, string $lastname, \DateTimeImmutable $dateOfBirth): ?Member;

    /**
     * @return Member[]
     */
    public function findByNameOrDateOfBirth(string $firstname, string $lastname, \DateTimeImmutable $dateOfBirth): array;

    /**
     * @return Member[]
     */
    public function search(
        string $keyword = '',
        int $yearOfBirth = 0,
        ?Location $location = null,
        ?Grade $grade = null,
        int $minYearOfBirth = 0,
        int $maxYearOfBirth = 0,
        ?bool $isActive = null,
    ): array;

    /**
     * @return Member[]
     */
    public function listActiveMembers(): array;

    /**
     * @return Member[]
     */
    public function getActiveMembersByFederationAndLocation(Federation $federation, Location $location): array;

    /**
     * @return Member[]
     */
    public function getActiveMembersByLocation(Location $location): array;

    /**
     * @return Member[]
     */
    public function getAll(): array;
}
