<?php

namespace App\YoshiKan\Application\Command\Member\ChangeSubscription;

use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\SubscriptionType;

class ChangeSubscription
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected int                $id,
        protected string             $contactFirstname,
        protected string             $contactLastname,
        protected string             $contactEmail,
        protected string             $contactPhone,
        protected string             $firstname,
        protected string             $lastname,
        protected string             $dateOfBirthDD,
        protected string             $dateOfBirthMM,
        protected string             $dateOfBirthYYYY,
        protected \DateTimeImmutable $dateOfBirth,
        protected Gender             $gender,
        protected bool               $newMember,
        protected SubscriptionType   $type,
        protected int                $locationId,
        protected int                $numberOfTraining,
        protected bool               $extraTraining,
        protected bool               $reductionFamily,
        protected bool               $judogiBelt,
        protected string             $remarks,
        protected float              $total,
        protected int                $judogiId,
        protected float              $judogiPrice,
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
            intval($json->id),
            trim($json->contactFirstname),
            trim($json->contactLastname),
            trim($json->contactEmail),
            trim($json->contactPhone),
            trim($json->firstname),
            trim($json->lastname),
            intval($json->dateOfBirthDD),
            intval($json->dateOfBirthMM),
            intval($json->dateOfBirthYYYY),
            new \DateTimeImmutable($json->dateOfBirth),
            Gender::from($json->gender),
            boolval($json->newMember),
            SubscriptionType::from($json->type),
            intval($json->locationId),
            intval($json->numberOfTraining),
            boolval($json->extraTraining),
            boolval($json->reductionFamily),
            boolval($json->judogiBelt),
            trim($json->remarks),
            floatval($json->total),
            intval($json->judogiId),
            floatval($json->judogiPrice),
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getId(): int
    {
        return $this->id;
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

    public function getDateOfBirthDD(): string
    {
        return $this->dateOfBirthDD;
    }

    public function getDateOfBirthMM(): string
    {
        return $this->dateOfBirthMM;
    }

    public function getDateOfBirthYYYY(): string
    {
        return $this->dateOfBirthYYYY;
    }

    public function getDateOfBirth(): \DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function isNewMember(): bool
    {
        return $this->newMember;
    }

    public function getType(): SubscriptionType
    {
        return $this->type;
    }

    public function getLocationId(): int
    {
        return $this->locationId;
    }

    public function getNumberOfTraining(): int
    {
        return $this->numberOfTraining;
    }

    public function isExtraTraining(): bool
    {
        return $this->extraTraining;
    }

    public function isReductionFamily(): bool
    {
        return $this->reductionFamily;
    }

    public function isJudogiBelt(): bool
    {
        return $this->judogiBelt;
    }

    public function getRemarks(): string
    {
        return $this->remarks;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getJudogiId(): int
    {
        return $this->judogiId;
    }

    public function getJudogiPrice(): float
    {
        return $this->judogiPrice;
    }
}
