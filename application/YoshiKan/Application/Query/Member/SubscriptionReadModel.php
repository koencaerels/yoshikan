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

namespace App\YoshiKan\Application\Query\Member;

use App\YoshiKan\Domain\Model\Member\Subscription;

class SubscriptionReadModel implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int $id,
        protected string $uuid,
        protected string $status,
        protected string $contactFirstname,
        protected string $contactLastname,
        protected string $contactEmail,
        protected string $contactPhone,
        protected string $firstname,
        protected string $lastname,
        protected \DateTimeImmutable $dateOfBirth,
        protected string $gender,
        protected string $type,
        protected int $numberOfTraining,
        protected bool $isExtraTraining,
        protected bool $isNewMember,
        protected bool $isReductionFamily,
        protected bool $isJudogiBelt,
        protected float $judogiPrice,
        protected string $remarks,
        protected float $total,
        protected bool $isPaymentOverviewSend,
        protected PeriodReadModel $period,
        protected LocationReadModel $location,
        protected array $settings,
        protected ?MemberReadModel $member,
        protected ?JudogiReadModel $judogi,
        protected ?string $nationalRegisterNumber,
        protected ?string $addressStreet,
        protected ?string $addressNumber,
        protected ?string $addressBox,
        protected ?string $addressZip,
        protected ?string $addressCity,
    ) {
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
        $json->nationalRegisterNumber = $this->getNationalRegisterNumber();
        $json->dateOfBirth = $this->getDateOfBirth()->format(\DateTimeInterface::ATOM);
        $json->gender = $this->getGender();
        $json->type = $this->getType();
        $json->numberOfTraining = $this->getNumberOfTraining();
        $json->isExtraTraining = $this->isExtraTraining();
        $json->isNewMember = $this->isNewMember();
        $json->isReductionFamily = $this->isReductionFamily();
        $json->isJudogiBelt = $this->isJudogiBelt();
        $json->judogiPrice = $this->getJudogiPrice();
        $json->remarks = $this->getRemarks();
        $json->total = $this->getTotal();
        $json->isPaymentOverviewSend = $this->isPaymentOverviewSend();
        $json->settings = $this->getSettings();
        $json->period = $this->getPeriod();
        $json->location = $this->getLocation();
        $json->member = $this->getMember();
        $json->judogi = $this->getJudogi();
        $json->addressStreet = $this->getAddressStreet();
        $json->addressNumber = $this->getAddressNumber();
        $json->addressBox = $this->getAddressBox();
        $json->addressZip = $this->getAddressZip();
        $json->addressCity = $this->getAddressCity();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from model
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromModel(Subscription $model): self
    {
        $memberReadModel = null;
        if (!is_null($model->getMember())) {
            $memberReadModel = MemberReadModel::hydrateFromModel($model->getMember());
        }
        $judogiReadModel = null;
        if (!is_null($model->getJudogi())) {
            $judogiReadModel = JudogiReadModel::hydrateFromModel($model->getJudogi());
        }

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
            $model->getJudogiPrice(),
            $model->getRemarks(),
            $model->getTotal(),
            $model->isPaymentOverviewSend(),
            PeriodReadModel::hydrateFromModel($model->getPeriod()),
            LocationReadModel::hydrateFromModel($model->getLocation()),
            $model->getSettings(),
            $memberReadModel,
            $judogiReadModel,
            $model->getNationalRegisterNumber(),
            $model->getAddressStreet(),
            $model->getAddressNumber(),
            $model->getAddressBox(),
            $model->getAddressZip(),
            $model->getAddressCity()
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

    public function getMember(): ?MemberReadModel
    {
        return $this->member;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getJudogi(): ?JudogiReadModel
    {
        return $this->judogi;
    }

    public function getJudogiPrice(): float
    {
        return $this->judogiPrice;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function isPaymentOverviewSend(): bool
    {
        return $this->isPaymentOverviewSend;
    }

    public function getNationalRegisterNumber(): ?string
    {
        return $this->nationalRegisterNumber;
    }

    public function getAddressStreet(): ?string
    {
        return $this->addressStreet;
    }

    public function getAddressNumber(): ?string
    {
        return $this->addressNumber;
    }

    public function getAddressBox(): ?string
    {
        return $this->addressBox;
    }

    public function getAddressZip(): ?string
    {
        return $this->addressZip;
    }

    public function getAddressCity(): ?string
    {
        return $this->addressCity;
    }
}
