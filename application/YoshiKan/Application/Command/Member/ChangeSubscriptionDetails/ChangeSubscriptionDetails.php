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

namespace App\YoshiKan\Application\Command\Member\ChangeSubscriptionDetails;

class ChangeSubscriptionDetails
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected int $subscriptionId,
        protected int $memberId,

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
        protected string $email,
        protected string $nationalRegisterNumber,
        protected \DateTimeImmutable $dateOfBirth,
        protected string $gender,

        protected \DateTimeImmutable $memberSubscriptionStart,
        protected string $memberSubscriptionStartMM,
        protected string $memberSubscriptionStartYY,
        protected \DateTimeImmutable $memberSubscriptionEnd,
        protected float $memberSubscriptionTotal,
        protected bool $memberSubscriptionIsPartSubscription,
        protected bool $memberSubscriptionIsHalfYear,
        protected bool $memberSubscriptionIsPayed,

        protected \DateTimeImmutable $licenseStart,
        protected string $licenseStartMM,
        protected string $licenseStartYY,
        protected \DateTimeImmutable $licenseEnd,
        protected float $licenseTotal,
        protected bool $licenseIsPartSubscription,
        protected bool $licenseIsPayed,

        protected int $numberOfTraining,
        protected bool $isExtraTraining,
        protected bool $isReductionFamily,

        protected float $total,
        protected string $remarks,

        protected bool $isJudogiBelt,
        protected float $newMemberFee,
        protected bool $sendMail = true,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————

    /**
     * @throws \Exception
     */
    public static function hydrateFromJson(\stdClass $json): self
    {
        return new self(
            intval($json->subscriptionId),
            intval($json->memberId),
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
            trim($json->email),
            '',
            new \DateTimeImmutable($json->dateOfBirth),
            trim($json->gender),
            new \DateTimeImmutable($json->memberSubscriptionStart),
            trim($json->memberSubscriptionStartMM),
            trim($json->memberSubscriptionStartYY),
            new \DateTimeImmutable($json->memberSubscriptionEnd),
            floatval($json->memberSubscriptionTotal),
            boolval($json->memberSubscriptionIsPartSubscription),
            boolval($json->memberSubscriptionIsHalfYear),
            boolval($json->memberSubscriptionIsPayed),
            new \DateTimeImmutable($json->licenseStart),
            trim($json->licenseStartMM),
            trim($json->licenseStartYY),
            new \DateTimeImmutable($json->licenseEnd),
            floatval($json->licenseTotal),
            boolval($json->licenseIsPartSubscription),
            boolval($json->licenseIsPayed),
            intval($json->numberOfTraining),
            boolval($json->isExtraTraining),
            boolval($json->isReductionFamily),
            floatval($json->total),
            trim($json->remarks),
            boolval($json->isJudogiBelt),
            floatval($json->newMemberFee),
            boolval($json->sendEmail),
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

    public function getEmail(): string
    {
        return $this->email;
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

    public function getMemberSubscriptionStart(): \DateTimeImmutable
    {
        return $this->memberSubscriptionStart;
    }

    public function getMemberSubscriptionStartMM(): string
    {
        return $this->memberSubscriptionStartMM;
    }

    public function getMemberSubscriptionStartYY(): string
    {
        return $this->memberSubscriptionStartYY;
    }

    public function getMemberSubscriptionEnd(): \DateTimeImmutable
    {
        return $this->memberSubscriptionEnd;
    }

    public function getMemberSubscriptionTotal(): float
    {
        return $this->memberSubscriptionTotal;
    }

    public function getLicenseStart(): \DateTimeImmutable
    {
        return $this->licenseStart;
    }

    public function getLicenseStartMM(): string
    {
        return $this->licenseStartMM;
    }

    public function getLicenseStartYY(): string
    {
        return $this->licenseStartYY;
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

    public function isLicenseIsPayed(): bool
    {
        return $this->licenseIsPayed;
    }

    public function getNumberOfTraining(): int
    {
        return $this->numberOfTraining;
    }

    public function isExtraTraining(): bool
    {
        return $this->isExtraTraining;
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

    public function isMemberSubscriptionIsPartSubscription(): bool
    {
        return $this->memberSubscriptionIsPartSubscription;
    }

    public function isMemberSubscriptionIsHalfYear(): bool
    {
        return $this->memberSubscriptionIsHalfYear;
    }

    public function isMemberSubscriptionIsPayed(): bool
    {
        return $this->memberSubscriptionIsPayed;
    }

    public function getSubscriptionId(): int
    {
        return $this->subscriptionId;
    }

    public function getMemberId(): int
    {
        return $this->memberId;
    }

    public function getNewMemberFee(): float
    {
        return $this->newMemberFee;
    }

    public function isSendMail(): bool
    {
        return $this->sendMail;
    }
}
