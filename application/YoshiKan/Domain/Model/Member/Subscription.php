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

    #[ORM\Column(length: 36)]
    private string $type;

    #[ORM\Column]
    private int $numberOfTraining = 1;

    #[ORM\Column(options: ["default" => 0])]
    private bool $isExtraTraining = false;

    #[ORM\Column(options: ["default" => 0])]
    private bool $isNewMember = false;

    #[ORM\Column(options: ["default" => 0])]
    private bool $isReductionFamily = false;

    #[ORM\Column(options: ["default" => 0])]
    private bool $isJudogiBelt = false;

    #[ORM\Column(type: 'text')]
    private string $remarks;

    // ------------------------------------------------------------ associations

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Member", fetch: 'EXTRA_LAZY', inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Member $member;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Period", fetch: 'EXTRA_LAZY', inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private Period $period;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Location", fetch: 'EXTRA_LAZY', inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private Location $location;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid               $uuid,
        string             $contactFirstname,
        string             $contactLastname,
        string             $contactEmail,
        string             $contactPhone,
        string             $firstname,
        string             $lastname,
        \DateTimeImmutable $dateOfBirth,
        Gender             $gender,
        SubscriptionType   $type,
        int                $numberOfTraining,
        bool               $isExtraTraining,
        bool               $isNewMember,
        bool               $isReductionFamily,
        bool               $isJudogiBelt,
        string             $remarks,
        Period             $period,
        Location           $location,
    ) {
        $this->uuid = $uuid;
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
        $this->period = $period;
        $this->location = $location;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid               $uuid,
        string             $contactFirstname,
        string             $contactLastname,
        string             $contactEmail,
        string             $contactPhone,
        string             $firstname,
        string             $lastname,
        \DateTimeImmutable $dateOfBirth,
        Gender             $gender,
        SubscriptionType   $type,
        int                $numberOfTraining,
        bool               $isExtraTraining,
        bool               $isNewMember,
        bool               $isReductionFamily,
        bool               $isJudogiBelt,
        string             $remarks,
        Period             $period,
        Location           $location,
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
            $period,
            $location,
        );
    }

    // Changer..


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

    // —————————————————————————————————————————————————————————————————————————
    // Other model getters
    // —————————————————————————————————————————————————————————————————————————

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function getPeriod(): Period
    {
        return $this->period;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }
}
