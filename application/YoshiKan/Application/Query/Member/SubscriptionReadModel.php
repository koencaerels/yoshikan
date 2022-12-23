<?php

declare(strict_types=1);

namespace App\YoshiKan\Application\Query\Member;

use App\YoshiKan\Domain\Model\Member\Subscription;

class SubscriptionReadModel implements \JsonSerializable
{

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int                $id,
        protected string             $uuid,
        protected string             $status,
        protected string             $contactFirstname,
        protected string             $contactLastname,
        protected string             $contactEmail,
        protected string             $contactPhone,
        protected string             $firstname,
        protected string             $lastname,
        protected \DateTimeImmutable $dateOfBirth,
        protected string             $gender,
        protected string             $type,
        protected int                $numberOfTraining,
        protected bool               $isExtraTraining,
        protected bool               $isNewMember,
        protected bool               $isReductionFamily,
        protected bool               $isJudogiBelt,
        protected string             $remarks,
        protected PeriodReadModel    $period,
        protected LocationReadModel  $location,
    )
    {
    }

    // —————————————————————————————————————————————————————————————————————————
    // What to render as json
    // —————————————————————————————————————————————————————————————————————————

    public function jsonSerialize(): \stdClass
    {
        $json = new \stdClass();
        $json->id = $this->getId();
        $json->uuid = $this->getUuid();
        $json->status = $this->getStatus();
        $json->contactFirstname = $this->getContactFirstname();
        $json->contactLastname = $this->getContactLastname();
        $json->contactEmail = $this->getContactEmail();
        $json->contactPhone = $this->getContactPhone();
        $json->firstname = $this->getFirstname();
        $json->lastname = $this->getLastname();
        $json->dateOfBirth = $this->getDateOfBirth();
        $json->gender = $this->getGender();
        $json->type = $this->getType();
        $json->numberOfTraining = $this->getNumberOfTraining();
        $json->isExtraTraining = $this->isExtraTraining();
        $json->isNewMember = $this->isNewMember();
        $json->isReductionFamily = $this->isReductionFamily();
        $json->isJudogiBelt = $this->isJudogiBelt();
        $json->remarks = $this->getRemarks();
        $json->period = $this->getPeriod();
        $json->location = $this->getLocation();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from model
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromModel(Subscription $model): self
    {
        return new self(
            $model->getId(),
            $model->getUuid()->toRfc4122(),
            $model->getStatus()->value,
            $model->getContactFirstname(),
            $model->getContactLastname(),
            $model->getContactEmail(),
            $model->getContactPhone(),
            $model->getFirstname(),
            $model->getLastname(),
            $model->getDateOfBirth(),
            $model->getGender()->value,
            $model->getType()->value,
            $model->getNumberOfTraining(),
            $model->isExtraTraining(),
            $model->isNewMember(),
            $model->isReductionFamily(),
            $model->isJudogiBelt(),
            $model->getRemarks(),
            PeriodReadModel::hydrateFromModel($model->getPeriod()),
            LocationReadModel::hydrateFromModel($model->getLocation()),
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getStatus(): string
    {
        return $this->status;
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

    public function getPeriod(): PeriodReadModel
    {
        return $this->period;
    }

    public function getLocation(): LocationReadModel
    {
        return $this->location;
    }
}
