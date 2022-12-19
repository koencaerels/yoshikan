<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Common\ChecksumEntity;
use App\YoshiKan\Domain\Model\Common\IdEntity;
use App\YoshiKan\Domain\Model\Common\SequenceEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\LocationRepository::class)]
class Location
{
    use IdEntity;
    use ChecksumEntity;
    use BlameableEntity;
    use TimestampableEntity;
    use SequenceEntity;

    // -------------------------------------------------------------- attributes

    #[ORM\Column(length: 25)]
    private string $code;

    #[ORM\Column(length: 191)]
    private string $name;

    // ------------------------------------------------------------ associations

    #[ORM\OneToMany(mappedBy: "location", targetEntity: "App\YoshiKan\Domain\Model\Member\Member", fetch: "EXTRA_LAZY")]
    #[ORM\OrderBy(["id" => "DESC"])]
    private Collection $members;

    #[ORM\OneToMany(mappedBy: "location", targetEntity: "App\YoshiKan\Domain\Model\Member\Subscription", fetch: "EXTRA_LAZY")]
    #[ORM\OrderBy(["id" => "DESC"])]
    private Collection $subscriptions;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid   $uuid,
        string $code,
        string $name,
    ) {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->name = $name;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid   $uuid,
        string $code,
        string $name,
    ): self {
        return new self(
            $uuid,
            $code,
            $name,
        );
    }

    public function change(
        string $code,
        string $name,
    ): void {
        $this->code = $code;
        $this->name = $name;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Other model getters
    // —————————————————————————————————————————————————————————————————————————

    public function getMembers(): array
    {
        return $this->members->getValues();
    }

    public function getSubscriptions(): array
    {
        return $this->subscriptions->getValues();
    }
}
