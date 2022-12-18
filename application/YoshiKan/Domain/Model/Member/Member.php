<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Common\ChecksumEntity;
use App\YoshiKan\Domain\Model\Common\IdEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
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

    // ------------------------------------------------------------- attributes
    #[ORM\Column(length: 191)]
    private string $firstname;

    #[ORM\Column(length: 191)]
    private string $lastname;

    #[ORM\Column]
    private \DateTimeImmutable $dateOfBirth;

    #[ORM\Column(length: 36)]
    private string $gender;

    // ----------------------------------------------------------- associations

    #[ORM\OneToMany(mappedBy: "member", targetEntity: "App\YoshiKan\Domain\Model\Member\Subscription", fetch: "EXTRA_LAZY")]
    #[ORM\OrderBy(["id" => "DESC"])]
    private Collection $subscriptions;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Grade", fetch: "EXTRA_LAZY", inversedBy: "members")]
    #[ORM\JoinColumn(nullable: false)]
    private Grade $grade;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Location", fetch: "EXTRA_LAZY", inversedBy: "members")]
    #[ORM\JoinColumn(nullable: false)]
    private Location $location;

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
        // -------------------------------------------------- set the attributes
        $this->uuid = $uuid;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->dateOfBirth = $dateOfBirth;
        $this->gender = $gender->value;
        // ------------------------------------------------ set the associations
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

    public function change(
        string $firstname,
        string $lastname,
    ): void
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
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

    // —————————————————————————————————————————————————————————————————————————
    // Other model getters
    // —————————————————————————————————————————————————————————————————————————

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
}
