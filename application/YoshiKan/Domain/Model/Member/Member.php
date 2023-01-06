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

    #[ORM\Column(type: 'text')]
    private string $remarks;

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

    #[ORM\OneToMany(mappedBy:"member",targetEntity: "App\YoshiKan\Domain\Model\Member\GradeLog", fetch:"EXTRA_LAZY")]
    #[ORM\JoinColumn(nullable: true)]
    #[ORM\OrderBy(["id" => "ASC"])]
    private ?Collection $gradelogs;

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
        );
    }

    public function changeDetails(
        string $firstname,
        string $lastname,
    ): void
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function changeGrade(Grade $grade): void
    {
        $this->grade = $grade;
    }

    public function changeRemarks(string $remarks): void
    {
        $this->remarks = $remarks;
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

    public function getRemarks(): string
    {
        return $this->remarks;
    }

    public function getGradeLogs(): array
    {
        return $this->gradelogs->getValues();
    }
}
