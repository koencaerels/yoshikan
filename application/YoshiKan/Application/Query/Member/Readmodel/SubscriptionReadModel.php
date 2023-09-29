<?php

declare(strict_types=1);

namespace App\YoshiKan\Application\Query\Member\Readmodel;

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
        protected string $type,
        protected string $contactFirstname,
        protected string $contactLastname,
        protected string $contactEmail,
        protected string $contactPhone,
        protected string $firstname,
        protected string $lastname,
        protected \DateTimeImmutable $dateOfBirth,
        protected string $gender,
        protected int $numberOfTraining,
        protected bool $isExtraTraining,
        protected bool $isNewMember,
        protected bool $isReductionFamily,
        protected bool $isJudogiBelt,
        protected string $remarks,
        protected float $total,
        protected \stdClass $settings,
        protected bool $isPaymentOverviewSend,
        protected bool $isPrinted,
        protected string $nationalRegisterNumber,
        protected string $addressStreet,
        protected string $addressNumber,
        protected string $addressBox,
        protected string $addressZip,
        protected string $addressCity,
        protected \DateTimeImmutable $memberSubscriptionStart,
        protected \DateTimeImmutable $memberSubscriptionEnd,
        protected float $memberSubscriptionTotal,
        protected bool $memberSubscriptionIsPartSubscription,
        protected bool $memberSubscriptionIsHalfYear,
        protected \DateTimeImmutable $licenseStart,
        protected \DateTimeImmutable $licenseEnd,
        protected float $licenseTotal,
        protected bool $licenseIsPartSubscription,
        protected LocationReadModel $location,
        protected FederationReadModel $federation,
        protected array $subscriptionitems,
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
        $json->type = $this->getType();
        $json->contactFirstname = $this->getContactFirstname();
        $json->contactLastname = $this->getContactLastname();
        $json->contactEmail = $this->getContactEmail();
        $json->contactPhone = $this->getContactPhone();
        $json->firstname = $this->getFirstname();
        $json->lastname = $this->getLastname();
        $json->dateOfBirth = $this->getDateOfBirth();
        $json->gender = $this->getGender();
        $json->numberOfTraining = $this->getNumberOfTraining();
        $json->isExtraTraining = $this->isExtraTraining();
        $json->isNewMember = $this->isNewMember();
        $json->isReductionFamily = $this->isReductionFamily();
        $json->isJudogiBelt = $this->isJudogiBelt();
        $json->remarks = $this->getRemarks();
        $json->total = $this->getTotal();
        $json->settings = $this->getSettings();
        $json->isPaymentOverviewSend = $this->isPaymentOverviewSend();
        $json->isPrinted = $this->isPrinted();
        $json->nationalRegisterNumber = $this->getNationalRegisterNumber();
        $json->addressStreet = $this->getAddressStreet();
        $json->addressNumber = $this->getAddressNumber();
        $json->addressBox = $this->getAddressBox();
        $json->addressZip = $this->getAddressZip();
        $json->addressCity = $this->getAddressCity();
        $json->memberSubscriptionStart = $this->getMemberSubscriptionStart();
        $json->memberSubscriptionEnd = $this->getMemberSubscriptionEnd();
        $json->memberSubscriptionTotal = $this->getMemberSubscriptionTotal();
        $json->memberSubscriptionIsPartSubscription = $this->memberSubscriptionIsPartSubscription();
        $json->memberSubscriptionIsHalfYear = $this->isMemberSubscriptionIsHalfYear();
        $json->licenseStart = $this->getLicenseStart();
        $json->licenseEnd = $this->getLicenseEnd();
        $json->licenseTotal = $this->getLicenseTotal();
        $json->licenseIsPartSubscription = $this->licenseIsPartSubscription();
        $json->location = $this->getLocation();
        $json->federation = $this->getFederation();
        $json->subscriptionitems = $this->getSubscriptionitems();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from model
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromModel(Subscription $model): self
    {
        $itemCollection = new SubscriptionItemReadModelCollection();
        foreach ($model->getSubscriptionItems() as $item) {
            $itemCollection->addItem(SubscriptionItemReadModel::hydrateFromModel($item));
        }

        return new self(
            $model->getId(),
            $model->getUuid()->toRfc4122(),
            $model->getStatus()->value,
            $model->getType()->value,
            $model->getContactFirstname(),
            $model->getContactLastname(),
            $model->getContactEmail(),
            $model->getContactPhone(),
            $model->getFirstname(),
            $model->getLastname(),
            $model->getDateOfBirth(),
            $model->getGender()->value,
            $model->getNumberOfTraining(),
            $model->isExtraTraining(),
            $model->isNewMember(),
            $model->isReductionFamily(),
            $model->isJudogiBelt(),
            $model->getRemarks(),
            $model->getTotal(),
            $model->getSettings(),
            $model->isPaymentOverviewSend(),
            $model->isPrinted(),
            $model->getNationalRegisterNumber(),
            $model->getAddressStreet(),
            $model->getAddressNumber(),
            $model->getAddressBox(),
            $model->getAddressZip(),
            $model->getAddressCity(),
            $model->getMemberSubscriptionStart(),
            $model->getMemberSubscriptionEnd(),
            $model->getMemberSubscriptionTotal(),
            $model->memberSubscriptionIsPartSubscription(),
            $model->isMemberSubscriptionIsHalfYear(),
            $model->getLicenseStart(),
            $model->getLicenseEnd(),
            $model->getLicenseTotal(),
            $model->licenseIsPartSubscription(),
            LocationReadModel::hydrateFromModel($model->getLocation()),
            FederationReadModel::hydrateFromModel($model->getFederation()),
            $itemCollection->getCollection(),
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

    public function getType(): string
    {
        return $this->type;
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

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getSettings(): \stdClass
    {
        return $this->settings;
    }

    public function isPaymentOverviewSend(): bool
    {
        return $this->isPaymentOverviewSend;
    }

    public function getNationalRegisterNumber(): string
    {
        return $this->nationalRegisterNumber;
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

    public function memberSubscriptionIsPartSubscription(): bool
    {
        return $this->memberSubscriptionIsPartSubscription;
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

    public function licenseIsPartSubscription(): bool
    {
        return $this->licenseIsPartSubscription;
    }

    public function getLocation(): LocationReadModel
    {
        return $this->location;
    }

    public function getFederation(): FederationReadModel
    {
        return $this->federation;
    }

    public function getSubscriptionitems(): array
    {
        return $this->subscriptionitems;
    }

    public function isMemberSubscriptionIsHalfYear(): bool
    {
        return $this->memberSubscriptionIsHalfYear;
    }

    public function isPrinted(): bool
    {
        return $this->isPrinted;
    }
}
