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
    private string $status = 'actief';

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

    // member subscription & license details

    #[ORM\Column]
    private \DateTimeImmutable $memberSubscriptionStart;

    #[ORM\Column]
    private \DateTimeImmutable $memberSubscriptionEnd;

    #[ORM\Column(options: ["default" => 0])]
    private bool $memberSubscriptionIsPayed;

    #[ORM\Column]
    private \DateTimeImmutable $licenseStart;

    #[ORM\Column]
    private \DateTimeImmutable $licenseEnd;

    #[ORM\Column(options: ["default" => 0])]
    private bool $licenseIsPayed;

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

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Federation", fetch: "EXTRA_LAZY", inversedBy: "members")]
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

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid               $uuid,
        string             $firstname,
        string             $lastname,
        \DateTimeImmutable $dateOfBirth,
        Gender             $gender,
        Grade              $grade,
        Location           $location,
        Federation         $federation,
        string             $email,
        string             $nationalRegisterNumber,
        string             $addressStreet,
        string             $addressNumber,
        string             $addressBox,
        string             $addressZip,
        string             $addressCity
    )
    {
        $this->uuid = $uuid;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->dateOfBirth = $dateOfBirth;
        $this->gender = $gender->value;
        $this->status = 'actief';
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
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid               $uuid,
        string             $firstname,
        string             $lastname,
        \DateTimeImmutable $dateOfBirth,
        Gender             $gender,
        Grade              $grade,
        Location           $location,
        Federation         $federation,
        string             $email,
        string             $nationalRegisterNumber,
        string             $addressStreet,
        string             $addressNumber,
        string             $addressBox,
        string             $addressZip,
        string             $addressCity
    ): self
    {
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
            $addressCity
        );
    }

    public function changeDetails(
        string             $firstname,
        string             $lastname,
        Gender             $gender,
        \DateTimeImmutable $dateOfBirth,
        MemberStatus       $status,
        Location           $location,
        string             $nationalRegisterNumber,
        string             $email,
        string             $addressStreet,
        string             $addressNumber,
        string             $addressBox,
        string             $addressZip,
        string             $addressCity
    ): void
    {
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

    public function memberSubscriptionIsPayed(): bool
    {
        return $this->memberSubscriptionIsPayed;
    }

    public function getLicenseStart(): \DateTimeImmutable
    {
        return $this->licenseStart;
    }

    public function getLicenseEnd(): \DateTimeImmutable
    {
        return $this->licenseEnd;
    }

    public function licenseIsPayed(): bool
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

}
