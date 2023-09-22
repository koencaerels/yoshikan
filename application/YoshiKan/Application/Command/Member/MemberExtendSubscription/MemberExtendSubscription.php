<?php

namespace App\YoshiKan\Application\Command\Member\MemberExtendSubscription;

class MemberExtendSubscription
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected int $memberId,
        protected int $federationId,
        protected int $locationId,

        protected string $contactFirstname,
        protected string $contactLastname,
        protected string $contactEmail,
        protected string $contactPhone,

        protected string $firstname,
        protected string $lastname,
        protected \DateTimeImmutable $dateOfBirth,
        protected string $gender,

        protected string $type,
        protected \DateTimeImmutable $memberSubscriptionStart,
        protected \DateTimeImmutable $memberSubscriptionEnd,
        protected float $memberSubscriptionTotal,
        protected bool $memberSubscriptionIsPartSubscription,
        protected bool $memberSubscriptionIsHalfYear,

        protected \DateTimeImmutable $licenseStart,
        protected \DateTimeImmutable $licenseEnd,
        protected float $licenseTotal,
        protected bool $licenseIsPartSubscription,

        protected int $numberOfTraining,
        protected bool $isExtraTraining,
        protected bool $isNewMember,
        protected bool $isReductionFamily,
        protected bool $isJudogiBelt,

        protected string $remarks,
        protected float $total,

        protected array $items,
    ) {
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

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getDateOfBirth(): \DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMemberSubscriptionStart(): \DateTimeImmutable
    {
        return $this->memberSubscriptionStart;
    }

    public function getMemberSubscriptionEnd(): \DateTimeImmutable
    {
        return $this->memberSubscriptionEnd;
    }

    public function getMemberSubscriptionTotal(): float
    {
        return $this->memberSubscriptionTotal;
    }

    public function isMemberSubscriptionIsPartSubscription(): bool
    {
        return $this->memberSubscriptionIsPartSubscription;
    }

    public function isMemberSubscriptionIsHalfYear(): bool
    {
        return $this->memberSubscriptionIsHalfYear;
    }

    public function getLicenseStart(): \DateTimeImmutable
    {
        return $this->licenseStart;
    }

    public function getLicenseEnd(): \DateTimeImmutable
    {
        return $this->licenseEnd;
    }

    public function getLicenseTotal(): float
    {
        return $this->licenseTotal;
    }

    public function isLicenseIsPartSubscription(): bool
    {
        return $this->licenseIsPartSubscription;
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

    public function isJudogiBelt(): bool
    {
        return $this->isJudogiBelt;
    }

    public function getRemarks(): string
    {
        return $this->remarks;
    }

    public function getItems(): array
    {
        return $this->items;
    }

}
