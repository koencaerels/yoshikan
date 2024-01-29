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

namespace App\YoshiKan\Application\Command\Member\ChangeMemberSubscription;

class ChangeMemberSubscription
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————
    private function __construct(
        protected int $memberId,
        protected int $federationId,
        protected \DateTimeImmutable $membershipStart,
        protected \DateTimeImmutable $membershipEnd,
        protected \DateTimeImmutable $licenseStart,
        protected \DateTimeImmutable $licenseEnd,
        protected bool $memberShipIsHalfYear,
        protected int $numberOfTraining,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydration
    // —————————————————————————————————————————————————————————————————————————

    /**
     * @throws \Exception
     */
    public static function hydrateFromJson(\stdClass $json): self
    {
        return new self(
            (int) $json->memberId,
            (int) $json->federationId,
            new \DateTimeImmutable($json->membershipStart),
            new \DateTimeImmutable($json->membershipEnd),
            new \DateTimeImmutable($json->licenseStart),
            new \DateTimeImmutable($json->licenseEnd),
            (bool) $json->memberShipIsHalfYear,
            (int) $json->numberOfTraining,
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getMemberId(): int
    {
        return $this->memberId;
    }

    public function getFederationId(): int
    {
        return $this->federationId;
    }

    public function getMembershipStart(): \DateTimeImmutable
    {
        return $this->membershipStart;
    }

    public function getLicenseStart(): \DateTimeImmutable
    {
        return $this->licenseStart;
    }

    public function isMemberShipIsHalfYear(): bool
    {
        return $this->memberShipIsHalfYear;
    }

    public function getNumberOfTraining(): int
    {
        return $this->numberOfTraining;
    }

    public function getMembershipEnd(): \DateTimeImmutable
    {
        return $this->membershipEnd;
    }

    public function setMembershipEnd(\DateTimeImmutable $membershipEnd): void
    {
        $this->membershipEnd = $membershipEnd;
    }

    public function getLicenseEnd(): \DateTimeImmutable
    {
        return $this->licenseEnd;
    }

    public function setLicenseEnd(\DateTimeImmutable $licenseEnd): void
    {
        $this->licenseEnd = $licenseEnd;
    }
}
