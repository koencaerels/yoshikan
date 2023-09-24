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
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\MemberRepository::class)]
class Member
{
    use IdEntity;
    use ChecksumEntity;
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Column(length: 36)]
    private string $status;

    // ------------------------------------------------------
    // contact details
    // ------------------------------------------------------

    #[ORM\Column(length: 191)]
    private string $contactFirstname;

    #[ORM\Column(length: 191)]
    private string $contactLastname;

    #[ORM\Column(length: 191)]
    private string $contactEmail;

    #[ORM\Column(length: 191)]
    private string $contactPhone;

    // ------------------------------------------------------
    // member details
    // ------------------------------------------------------

    #[ORM\Column(length: 191)]
    private string $firstname;

    #[ORM\Column(length: 191)]
    private string $lastname;

    #[ORM\Column]
    private \DateTimeImmutable $dateOfBirth;

    #[ORM\Column(length: 36)]
    private string $gender;

    #[ORM\Column(length: 16)]
    private string $nationalRegisterNumber;

    #[ORM\Column(length: 191)]
    private string $email;

    #[ORM\Column(length: 191)]
    private string $addressStreet;

    #[ORM\Column(length: 10)]
    private string $addressNumber;

    #[ORM\Column(length: 10)]
    private string $addressBox;

    #[ORM\Column(length: 10)]
    private string $addressZip;

    #[ORM\Column(length: 191)]
    private string $addressCity;

    #[ORM\Column(type: 'text')]
    private string $remarks;

    #[ORM\Column(length: 191)]
    private string $profileImage;

    // ------------------------------------------------------
    // member subscription & license details
    // ------------------------------------------------------

    #[ORM\Column]
    private \DateTimeImmutable $memberSubscriptionStart;

    #[ORM\Column]
    private \DateTimeImmutable $memberSubscriptionEnd;

    #[ORM\Column(options: ['default' => 0])]
    private bool $memberSubscriptionIsPayed;

    #[ORM\Column(options: ['default' => 0])]
    private bool $memberSubscriptionIsHalfYear;

    #[ORM\Column]
    private \DateTimeImmutable $licenseStart;

    #[ORM\Column]
    private \DateTimeImmutable $licenseEnd;

    #[ORM\Column(options: ['default' => 0])]
    private bool $licenseIsPayed;

    #[ORM\Column]
    private int $numberOfTraining;

    // ----------------------------------------------------------- associations

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: "App\YoshiKan\Domain\Model\Member\Subscription", fetch: 'EXTRA_LAZY')]
    #[ORM\OrderBy(['id' => 'DESC'])]
    private Collection $subscriptions;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Grade", fetch: 'EXTRA_LAZY', inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false)]
    private Grade $grade;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Location", fetch: 'EXTRA_LAZY', inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false)]
    private Location $location;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Federation", fetch: 'EXTRA_LAZY', inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false)]
    private Federation $federation;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: "App\YoshiKan\Domain\Model\Member\GradeLog", fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: true)]
    #[ORM\OrderBy(['id' => 'ASC'])]
    private ?Collection $gradeLogs;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: "App\YoshiKan\Domain\Model\Member\MemberImage", fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: true)]
    #[ORM\OrderBy(['id' => 'DESC'])]
    private ?Collection $memberImages;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: "App\YoshiKan\Domain\Model\Message\Message", fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: true)]
    #[ORM\OrderBy(['id' => 'DESC'])]
    private ?Collection $messages;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid $uuid,
        string $firstname,
        string $lastname,
        \DateTimeImmutable $dateOfBirth,
        Gender $gender,
        Grade $grade,
        Location $location,
        Federation $federation,
        string $email,
        string $nationalRegisterNumber,
        string $addressStreet,
        string $addressNumber,
        string $addressBox,
        string $addressZip,
        string $addressCity,
        int $numberOfTraining,
    ) {
        $this->uuid = $uuid;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->dateOfBirth = $dateOfBirth;
        $this->gender = $gender->value;
        $this->status = MemberStatus::ACTIVE->value;
        $this->grade = $grade;
        $this->location = $location;
        $this->federation = $federation;
        $this->email = $email;
        $this->remarks = '';
        $this->profileImage = '';
        $this->nationalRegisterNumber = $nationalRegisterNumber;
        $this->addressStreet = $addressStreet;
        $this->addressNumber = $addressNumber;
        $this->addressBox = $addressBox;
        $this->addressZip = $addressZip;
        $this->addressCity = $addressCity;
        $this->numberOfTraining = $numberOfTraining;

        // -- default settings when user is created
        $this->memberSubscriptionStart = new \DateTimeImmutable();
        $this->memberSubscriptionEnd = new \DateTimeImmutable();
        $this->memberSubscriptionIsHalfYear = false;
        $this->memberSubscriptionIsPayed = false;
        $this->licenseStart = new \DateTimeImmutable();
        $this->licenseEnd = new \DateTimeImmutable();
        $this->licenseIsPayed = false;

        $this->contactFirstname = $firstname;
        $this->contactLastname = $lastname;
        $this->contactEmail = $email;
        $this->contactPhone = '';
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid $uuid,
        string $firstname,
        string $lastname,
        \DateTimeImmutable $dateOfBirth,
        Gender $gender,
        Grade $grade,
        Location $location,
        Federation $federation,
        string $email,
        string $nationalRegisterNumber,
        string $addressStreet,
        string $addressNumber,
        string $addressBox,
        string $addressZip,
        string $addressCity,
        int $numberOfTraining,
    ): self {
        return new self(
            $uuid,
            $firstname,
            $lastname,
            $dateOfBirth,
            $gender,
            $grade,
            $location,
            $federation,
            $email,
            $nationalRegisterNumber,
            $addressStreet,
            $addressNumber,
            $addressBox,
            $addressZip,
            $addressCity,
            $numberOfTraining
        );
    }

    public function changeDetails(
        string $firstname,
        string $lastname,
        Gender $gender,
        \DateTimeImmutable $dateOfBirth,
        MemberStatus $status,
        Location $location,
        string $nationalRegisterNumber,
        string $email,
        string $addressStreet,
        string $addressNumber,
        string $addressBox,
        string $addressZip,
        string $addressCity,
        string $contactFirstname,
        string $contactLastname,
        string $contactEmail,
        string $contactPhone
    ): void {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->gender = $gender->value;
        $this->dateOfBirth = $dateOfBirth;
        $this->status = $status->value;
        $this->location = $location;
        $this->nationalRegisterNumber = $nationalRegisterNumber;
        $this->email = $email;
        $this->addressStreet = $addressStreet;
        $this->addressNumber = $addressNumber;
        $this->addressBox = $addressBox;
        $this->addressZip = $addressZip;
        $this->addressCity = $addressCity;
        $this->contactFirstname = $contactFirstname;
        $this->contactLastname = $contactLastname;
        $this->contactEmail = $contactEmail;
        $this->contactPhone = $contactPhone;
    }

    public function setSubscriptionDates(
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        bool $isHalfYearSubscription
    ): void {
        $this->memberSubscriptionStart = $start;
        $this->memberSubscriptionEnd = $end;
        $this->memberSubscriptionIsPayed = false;
        $this->memberSubscriptionIsHalfYear = $isHalfYearSubscription;
    }

    public function markSubscriptionAsPayed(): void
    {
        $this->memberSubscriptionIsPayed = true;
    }

    public function setLicenseDates(
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
    ): void {
        $this->licenseStart = $start;
        $this->licenseEnd = $end;
        $this->licenseIsPayed = false;
    }

    public function markLicenseAsPayed(): void
    {
        $this->licenseIsPayed = true;
    }

    public function changeGrade(Grade $grade): void
    {
        $this->grade = $grade;
    }

    public function changeRemarks(string $remarks): void
    {
        $this->remarks = $remarks;
    }

    public function setProfileImage(string $profileImage): void
    {
        $this->profileImage = $profileImage;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

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

    public function getStatus(): MemberStatus
    {
        return MemberStatus::from($this->status);
    }

    public function getStatusAsString(): string
    {
        return $this->status;
    }

    public function getGrade(): Grade
    {
        return $this->grade;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getSubscriptions(): array
    {
        return $this->subscriptions->getValues();
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

    public function getRemarks(): string
    {
        return $this->remarks;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMemberSubscriptionStart(): \DateTimeImmutable
    {
        return $this->memberSubscriptionStart;
    }

    public function getMemberSubscriptionEnd(): \DateTimeImmutable
    {
        return $this->memberSubscriptionEnd;
    }

    public function isMemberSubscriptionIsPayed(): bool
    {
        return $this->memberSubscriptionIsPayed;
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

    public function isLicenseIsPayed(): bool
    {
        return $this->licenseIsPayed;
    }

    public function getProfileImage(): string
    {
        return $this->profileImage;
    }

    public function getGradeLogs(): array
    {
        return $this->gradeLogs->getValues();
    }

    public function getMemberImages(): array
    {
        return $this->memberImages->getValues();
    }

    public function getFederation(): Federation
    {
        return $this->federation;
    }

    public function getNumberOfTraining(): int
    {
        return $this->numberOfTraining;
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

    public function getMessages(): array
    {
        return $this->messages->getValues();
    }
}
