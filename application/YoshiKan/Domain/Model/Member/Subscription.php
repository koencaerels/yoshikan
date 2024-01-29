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

use App\YoshiKan\Domain\Model\Common\ChecksumEntity;
use App\YoshiKan\Domain\Model\Common\IdEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\SubscriptionRepository::class)]
class Subscription
{
    use IdEntity;
    use ChecksumEntity;
    use BlameableEntity;
    use TimestampableEntity;

    // -------------------------------------------------------------- attributes
    #[ORM\Column(length: 36)]
    private string $status = 'nieuw';

    #[ORM\Column(length: 36)]
    private string $type;

    #[ORM\Column(options: ['default' => 0])]
    private bool $isPaymentOverviewSend = false;

    #[ORM\Column(length: 191)]
    private string $contactFirstname;

    #[ORM\Column(length: 191)]
    private string $contactLastname;

    #[ORM\Column(length: 191)]
    private string $contactEmail;

    #[ORM\Column(length: 191)]
    private string $contactPhone;

    #[ORM\Column(length: 191)]
    private string $firstname;

    #[ORM\Column(length: 191)]
    private string $lastname;

    #[ORM\Column]
    private \DateTimeImmutable $dateOfBirth;

    #[ORM\Column(length: 36)]
    private string $gender;

    #[ORM\Column]
    private int $numberOfTraining = 1;

    #[ORM\Column(options: ['default' => 0])]
    private bool $isExtraTraining = false;

    #[ORM\Column(options: ['default' => 0])]
    private bool $isNewMember = false;

    #[ORM\Column(options: ['default' => 0])]
    private float $newMemberFee = 0;

    #[ORM\Column(options: ['default' => 0])]
    private bool $isJudogiBelt = false;

    #[ORM\Column(options: ['default' => 0])]
    private bool $isReductionFamily = false;

    #[ORM\Column(type: 'text')]
    private string $remarks;

    #[ORM\Column(options: ['default' => 0])]
    private float $total = 0;

    #[ORM\Column(type: 'json')]
    private array $settings;

    // -- subscription configuration  ------------------------------------------

    #[ORM\Column]
    private \DateTimeImmutable $memberSubscriptionStart;

    #[ORM\Column]
    private \DateTimeImmutable $memberSubscriptionEnd;

    #[ORM\Column(options: ['default' => 0])]
    private float $memberSubscriptionTotal = 0;

    #[ORM\Column(options: ['default' => 0])]
    private bool $memberSubscriptionIsPartSubscription;

    #[ORM\Column(options: ['default' => 0])]
    private bool $memberSubscriptionIsHalfYear;

    #[ORM\Column(options: ['default' => 0])]
    private bool $memberSubscriptionIsPayed;

    #[ORM\Column]
    private \DateTimeImmutable $licenseStart;

    #[ORM\Column]
    private \DateTimeImmutable $licenseEnd;

    #[ORM\Column(options: ['default' => 0])]
    private float $licenseTotal = 0;

    #[ORM\Column(options: ['default' => 0])]
    private bool $licenseIsPartSubscription;

    #[ORM\Column(options: ['default' => 0])]
    private bool $licenseIsPayed;

    #[ORM\Column(options: ['default' => 0])]
    private bool $isPrinted;

    // -- extra fields for new members ------------------------------------------

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $nationalRegisterNumber = null;

    #[ORM\Column(length: 191, nullable: true)]
    private ?string $addressStreet = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $addressNumber = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $addressBox = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $addressZip = null;

    #[ORM\Column(length: 191, nullable: true)]
    private ?string $addressCity = null;

    // -- payment fields --------------------------------------------------------

    #[ORM\Column(length: 191)]
    private string $paymentLink = '';

    #[ORM\Column(length: 191)]
    private string $paymentLinkId = '';

    #[ORM\Column(length: 191)]
    private string $paymentId = '';

    #[ORM\Column(length: 36)]
    private string $paymentType = SubscriptionPaymentType::TRANSFER->value;

    // -- associations ----------------------------------------------------------
    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Member", fetch: 'EXTRA_LAZY', inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Member $member;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Location", fetch: 'EXTRA_LAZY', inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private Location $location;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Federation", fetch: 'EXTRA_LAZY', inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private Federation $federation;

    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: "App\YoshiKan\Domain\Model\Member\SubscriptionItem", fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\OrderBy(['sequence' => 'ASC'])]
    private Collection $items;

    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: "App\YoshiKan\Domain\Model\Message\Message", fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: true)]
    #[ORM\OrderBy(['id' => 'DESC'])]
    private ?Collection $messages;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid $uuid,
        string $contactFirstname,
        string $contactLastname,
        string $contactEmail,
        string $contactPhone,
        string $firstname,
        string $lastname,
        \DateTimeImmutable $dateOfBirth,
        Gender $gender,
        SubscriptionType $type,
        int $numberOfTraining,
        bool $isExtraTraining,
        bool $isNewMember,
        bool $isReductionFamily,
        bool $isJudogiBelt,
        string $remarks,
        Location $location,
        array $settings,
        Federation $federation,
        \DateTimeImmutable $memberSubscriptionStart,
        \DateTimeImmutable $memberSubscriptionEnd,
        float $memberSubscriptionTotal,
        bool $memberSubscriptionIsPartSubscription,
        bool $memberSubscriptionIsHalfYear,
        bool $memberSubscriptionIsPayed,
        \DateTimeImmutable $licenseStart,
        \DateTimeImmutable $licenseEnd,
        float $licenseTotal,
        bool $licenseIsPartSubscription,
        bool $licenseIsPayed,
        float $newMemberFee = 0,
    ) {
        $this->uuid = $uuid;
        $this->status = SubscriptionStatus::NEW->value;

        $this->contactFirstname = $contactFirstname;
        $this->contactLastname = $contactLastname;
        $this->contactEmail = $contactEmail;
        $this->contactPhone = $contactPhone;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->dateOfBirth = $dateOfBirth;
        $this->gender = $gender->value;
        $this->type = $type->value;
        $this->numberOfTraining = $numberOfTraining;
        $this->isExtraTraining = $isExtraTraining;
        $this->isNewMember = $isNewMember;
        $this->isReductionFamily = $isReductionFamily;
        $this->isJudogiBelt = $isJudogiBelt;
        $this->remarks = $remarks;
        $this->location = $location;
        $this->settings = $settings;

        $this->federation = $federation;
        $this->memberSubscriptionStart = $memberSubscriptionStart;
        $this->memberSubscriptionEnd = $memberSubscriptionEnd;
        $this->memberSubscriptionTotal = $memberSubscriptionTotal;
        $this->memberSubscriptionIsPartSubscription = $memberSubscriptionIsPartSubscription;
        $this->memberSubscriptionIsHalfYear = $memberSubscriptionIsHalfYear;
        $this->memberSubscriptionIsPayed = $memberSubscriptionIsPayed;
        $this->newMemberFee = $newMemberFee;
        $this->licenseStart = $licenseStart;
        $this->licenseEnd = $licenseEnd;
        $this->licenseTotal = $licenseTotal;
        $this->licenseIsPartSubscription = $licenseIsPartSubscription;
        $this->licenseIsPayed = $licenseIsPayed;

        $this->isPaymentOverviewSend = false;
        $this->isPrinted = false;

        $this->total = ceil($this->memberSubscriptionTotal + $this->licenseTotal);
        $this->items = new ArrayCollection();
        $this->member = null;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid $uuid,
        string $contactFirstname,
        string $contactLastname,
        string $contactEmail,
        string $contactPhone,
        string $firstname,
        string $lastname,
        \DateTimeImmutable $dateOfBirth,
        Gender $gender,
        SubscriptionType $type,
        int $numberOfTraining,
        bool $isExtraTraining,
        bool $isNewMember,
        bool $isReductionFamily,
        bool $isJudogiBelt,
        string $remarks,
        Location $location,
        array $settings,
        Federation $federation,
        \DateTimeImmutable $memberSubscriptionStart,
        \DateTimeImmutable $memberSubscriptionEnd,
        float $memberSubscriptionTotal,
        bool $memberSubscriptionIsPartSubscription,
        bool $memberSubscriptionIsHalfYear,
        bool $memberSubscriptionIsPayed,
        \DateTimeImmutable $licenseStart,
        \DateTimeImmutable $licenseEnd,
        float $licenseTotal,
        bool $licenseIsPartSubscription,
        bool $licenseIsPayed,
        float $newMemberFee = 0,
    ): self {
        return new self(
            $uuid,
            $contactFirstname,
            $contactLastname,
            $contactEmail,
            $contactPhone,
            $firstname,
            $lastname,
            $dateOfBirth,
            $gender,
            $type,
            $numberOfTraining,
            $isExtraTraining,
            $isNewMember,
            $isReductionFamily,
            $isJudogiBelt,
            $remarks,
            $location,
            $settings,
            $federation,
            $memberSubscriptionStart,
            $memberSubscriptionEnd,
            $memberSubscriptionTotal,
            $memberSubscriptionIsPartSubscription,
            $memberSubscriptionIsHalfYear,
            $memberSubscriptionIsPayed,
            $licenseStart,
            $licenseEnd,
            $licenseTotal,
            $licenseIsPartSubscription,
            $licenseIsPayed,
            $newMemberFee,
        );
    }

    public function change(
        string $contactFirstname,
        string $contactLastname,
        string $contactEmail,
        string $contactPhone,
        string $firstname,
        string $lastname,
        \DateTimeImmutable $dateOfBirth,
        Gender $gender,
        SubscriptionType $type,
        int $numberOfTraining,
        bool $isExtraTraining,
        bool $isNewMember,
        bool $isReductionFamily,
        bool $isJudogiBelt,
        string $remarks,
        float $total,
        Location $location,
    ): void {
        $this->contactFirstname = $contactFirstname;
        $this->contactLastname = $contactLastname;
        $this->contactEmail = $contactEmail;
        $this->contactPhone = $contactPhone;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->dateOfBirth = $dateOfBirth;
        $this->gender = $gender->value;
        $this->type = $type->value;
        $this->numberOfTraining = $numberOfTraining;
        $this->isExtraTraining = $isExtraTraining;
        $this->isNewMember = $isNewMember;
        $this->isReductionFamily = $isReductionFamily;
        $this->isJudogiBelt = $isJudogiBelt;
        $this->remarks = $remarks;
        $this->total = $total;
        $this->location = $location;
    }

    public function setNewMemberFields(
        string $nationalRegisterNumber,
        string $addressStreet,
        string $addressNumber,
        string $addressBox,
        string $addressZip,
        string $addressCity
    ): void {
        $this->nationalRegisterNumber = $nationalRegisterNumber;
        $this->addressStreet = $addressStreet;
        $this->addressNumber = $addressNumber;
        $this->addressBox = $addressBox;
        $this->addressZip = $addressZip;
        $this->addressCity = $addressCity;
    }

    public function fullChange(
        string $contactFirstname,
        string $contactLastname,
        string $contactEmail,
        string $contactPhone,
        string $firstname,
        string $lastname,
        \DateTimeImmutable $dateOfBirth,
        Gender $gender,
        SubscriptionType $type,
        int $numberOfTraining,
        bool $isExtraTraining,
        bool $isNewMember,
        bool $isReductionFamily,
        bool $isJudogiBelt,
        string $remarks,
        Location $location,
        Federation $federation,
        \DateTimeImmutable $memberSubscriptionStart,
        \DateTimeImmutable $memberSubscriptionEnd,
        float $memberSubscriptionTotal,
        bool $memberSubscriptionIsPartSubscription,
        bool $memberSubscriptionIsHalfYear,
        bool $memberSubscriptionIsPayed,
        \DateTimeImmutable $licenseStart,
        \DateTimeImmutable $licenseEnd,
        float $licenseTotal,
        bool $licenseIsPartSubscription,
        bool $licenseIsPayed,
        float $newMemberFee = 0,
    ): void {
        $this->contactFirstname = $contactFirstname;
        $this->contactLastname = $contactLastname;
        $this->contactEmail = $contactEmail;
        $this->contactPhone = $contactPhone;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->dateOfBirth = $dateOfBirth;
        $this->gender = $gender->value;
        $this->type = $type->value;
        $this->numberOfTraining = $numberOfTraining;
        $this->isExtraTraining = $isExtraTraining;
        $this->isNewMember = $isNewMember;
        $this->isReductionFamily = $isReductionFamily;
        $this->isJudogiBelt = $isJudogiBelt;
        $this->remarks = $remarks;
        $this->location = $location;
        $this->federation = $federation;
        $this->memberSubscriptionStart = $memberSubscriptionStart;
        $this->memberSubscriptionEnd = $memberSubscriptionEnd;
        $this->memberSubscriptionTotal = $memberSubscriptionTotal;
        $this->memberSubscriptionIsPartSubscription = $memberSubscriptionIsPartSubscription;
        $this->memberSubscriptionIsHalfYear = $memberSubscriptionIsHalfYear;
        $this->memberSubscriptionIsPayed = $memberSubscriptionIsPayed;
        $this->licenseStart = $licenseStart;
        $this->licenseEnd = $licenseEnd;
        $this->licenseTotal = $licenseTotal;
        $this->licenseIsPartSubscription = $licenseIsPartSubscription;
        $this->licenseIsPayed = $licenseIsPayed;
        $this->total = ceil($this->memberSubscriptionTotal + $this->licenseTotal);
        $this->newMemberFee = $newMemberFee;
        $this->items = new ArrayCollection();
    }

    public function changeStatus(SubscriptionStatus $status): void
    {
        $this->status = $status->value;
    }

    public function setMember(Member $member): void
    {
        $this->member = $member;
    }

    public function flagPaymentOverviewMailSend(): void
    {
        $this->isPaymentOverviewSend = true;
    }

    public function flagSubscriptionIsPrinted(): void
    {
        $this->isPrinted = true;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function updateSettings(array $settings): void
    {
        $this->settings = $settings;
    }

    public function clearItems(): void
    {
        $this->items = new ArrayCollection();
    }

    // —————————————————————————————————————————————————————————————————————————
    // Payment information setters
    // —————————————————————————————————————————————————————————————————————————

    public function setMolliePaymentInfo(
        string $paymentId,
        string $paymentLink,
        string $paymentLinkId,
    ): void {
        $this->paymentId = $paymentId;
        $this->paymentLink = $paymentLink;
        $this->paymentLinkId = $paymentLinkId;
    }

    public function setPaymentTypeInfo(SubscriptionPaymentType $type): void
    {
        $this->paymentType = $type->value;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getStatus(): SubscriptionStatus
    {
        return SubscriptionStatus::from($this->status);
    }

    public function getStatusAsString(): string
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

    public function getGender(): Gender
    {
        return Gender::from($this->gender);
    }

    public function getGenderAsString(): string
    {
        return $this->gender;
    }

    public function getType(): SubscriptionType
    {
        return SubscriptionType::from($this->type);
    }

    public function getTypeAsString(): string
    {
        return $this->type;
    }

    public function getNumberOfTraining(): ?int
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

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function isPaymentOverviewSend(): bool
    {
        return $this->isPaymentOverviewSend;
    }

    public function isPrinted(): bool
    {
        return $this->isPrinted;
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

    // —————————————————————————————————————————————————————————————————————————
    // Other model getters
    // —————————————————————————————————————————————————————————————————————————

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getFederation(): Federation
    {
        return $this->federation;
    }

    public function isMemberSubscriptionIsHalfYear(): bool
    {
        return $this->memberSubscriptionIsHalfYear;
    }

    public function isMemberSubscriptionIsPartSubscription(): bool
    {
        return $this->memberSubscriptionIsPartSubscription;
    }

    public function isMemberSubscriptionIsPayed(): bool
    {
        return $this->memberSubscriptionIsPayed;
    }

    public function isLicenseIsPartSubscription(): bool
    {
        return $this->licenseIsPartSubscription;
    }

    public function isLicenseIsPayed(): bool
    {
        return $this->licenseIsPayed;
    }

    public function getMessages(): array
    {
        return null !== $this->messages ? $this->messages->getValues() : [];
    }

    /**
     * @return SubscriptionItem[]
     */
    public function getItems(): array
    {
        return $this->items->getValues();
    }

    // —————————————————————————————————————————————————————————————————————————
    // Payment information fields
    // —————————————————————————————————————————————————————————————————————————

    public function getPaymentLink(): string
    {
        return $this->paymentLink;
    }

    public function getPaymentLinkId(): string
    {
        return $this->paymentLinkId;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    public function getNewMemberFee(): float
    {
        return $this->newMemberFee;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Subscription fee calculation function
    // —————————————————————————————————————————————————————————————————————————

    public function getSubscriptionFee(bool $withReduction = true): float
    {
        $memberShipFee = 0;
        if ($this->memberSubscriptionIsHalfYear) {
            if (1 === $this->numberOfTraining) {
                $memberShipFee = floatval($this->settings['halfYearlyFee1Training']);
            } else {
                $memberShipFee = floatval($this->settings['halfYearlyFee2Training']);
            }
        } else {
            if (1 === $this->numberOfTraining) {
                $memberShipFee = floatval($this->settings['yearlyFee1Training']);
            } else {
                $memberShipFee = floatval($this->settings['yearlyFee2Training']);
            }
        }

        // -- type extra training -------------------------------------------
        if ($this->isExtraTraining) {
            $memberShipFee += floatval($this->settings['extraTrainingFee']);
        }

        // -- reduction -----------------------------------------------------
        if ($this->isReductionFamily && $withReduction) {
            $reduction = floatval($this->settings['familyDiscount']) * $memberShipFee / 100;
            $memberShipFee = ceil($memberShipFee - $reduction);
        }

        return $memberShipFee;
    }

    public function calculate(): float
    {
        $memberShipFee = $this->getSubscriptionFee(false);

        // -- type welcome package ------------------------------------------
        $memberShipFee += floatval($this->getNewMemberFee());

        if ($this->isReductionFamily) {
            $reduction = floatval($this->settings['familyDiscount']) * $memberShipFee / 100;
            $memberShipFee = ceil($memberShipFee - $reduction);
        }

        // -- set some total counts -----------------------------------------

        if ($this->isMemberSubscriptionIsPartSubscription()) {
            $this->memberSubscriptionTotal = $memberShipFee;
        } else {
            $this->memberSubscriptionTotal = 0;
        }

        if ($this->licenseIsPartSubscription()) {
            $federationFee = $this->federation->getYearlySubscriptionFee();
            if (false === is_null($federationFee)) {
                $this->licenseTotal = $federationFee;
            } else {
                $this->licenseTotal = 0;
            }
        } else {
            $this->licenseTotal = 0;
        }

        $this->total = $this->memberSubscriptionTotal + $this->licenseTotal;

        return $this->total;
    }
}
