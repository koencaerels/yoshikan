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

namespace App\YoshiKan\Application\Command\Member\NewMemberWebSubscription;

class NewMemberWebSubscription
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected string $type,
        protected int $federationId,
        protected int $locationId,

        protected string $contactFirstname,
        protected string $contactLastname,
        protected string $contactEmail,
        protected string $contactPhone,

        protected string $addressStreet,
        protected string $addressNumber,
        protected string $addressBox,
        protected string $addressZip,
        protected string $addressCity,

        protected string $firstname,
        protected string $lastname,
        protected string $nationalRegisterNumber,
        protected \DateTimeImmutable $dateOfBirth,
        protected string $gender,

        protected bool $memberSubscriptionIsHalfYear,
        protected int $numberOfTraining,
        protected bool $isExtraTraining,
        protected bool $isNewMember,
        protected bool $isReductionFamily,

        protected float $total,
        protected string $remarks,

        protected bool $isJudogiBelt,
        protected string $honeyPot,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————

    /**
     * @throws \Exception
     */
    public static function hydrateFromJson($json): self
    {
        return new self(
            trim($json->type),
            intval($json->federationId),
            intval($json->locationId),
            trim($json->contactFirstname),
            trim($json->contactLastname),
            trim($json->contactEmail),
            trim($json->contactPhone),
            trim($json->addressStreet),
            trim($json->addressNumber),
            trim($json->addressBox),
            trim($json->addressZip),
            trim($json->addressCity),
            trim($json->firstname),
            trim($json->lastname),
            trim($json->nationalRegisterNumber),
            new \DateTimeImmutable($json->dateOfBirth),
            trim($json->gender),
            boolval($json->memberSubscriptionIsHalfYear),
            intval($json->numberOfTraining),
            boolval($json->isExtraTraining),
            boolval($json->isNewMember),
            boolval($json->isReductionFamily),
            floatval($json->total),
            trim($json->remarks),
            boolval($json->isJudogiBelt),
            trim($json->honeyPot),
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getType(): string
    {
        return $this->type;
    }

    public function getFederationId(): int
    {
        return $this->federationId;
    }

    public function getLocationId(): int
    {
        return $this->locationId;
    }

    public function getContactFirstname(): string
    {
        return $this->contactFirstname;
    }

    public function getContactLastname(): string
    {
        return $this->contactLastname;
    }

    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    public function getAddressStreet(): string
    {
        return $this->addressStreet;
    }

    public function getAddressNumber(): string
    {
        return $this->addressNumber;
    }

    public function getAddressBox(): string
    {
        return $this->addressBox;
    }

    public function getAddressZip(): string
    {
        return $this->addressZip;
    }

    public function getAddressCity(): string
    {
        return $this->addressCity;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getNationalRegisterNumber(): string
    {
        return $this->nationalRegisterNumber;
    }

    public function getDateOfBirth(): \DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getNumberOfTraining(): int
    {
        return $this->numberOfTraining;
    }

    public function isExtraTraining(): bool
    {
        return $this->isExtraTraining;
    }

    public function isNewMember(): bool
    {
        return $this->isNewMember;
    }

    public function isReductionFamily(): bool
    {
        return $this->isReductionFamily;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getRemarks(): string
    {
        return $this->remarks;
    }

    public function isJudogiBelt(): bool
    {
        return $this->isJudogiBelt;
    }

    public function isMemberSubscriptionIsHalfYear(): bool
    {
        return $this->memberSubscriptionIsHalfYear;
    }

    public function getHoneyPot(): string
    {
        return $this->honeyPot;
    }
}
