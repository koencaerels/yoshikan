<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Common\ChecksumEntity;
use App\YoshiKan\Domain\Model\Common\IdEntity;
use App\YoshiKan\Domain\Model\Common\SequenceEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\JudogiRepository::class)]
class Judogi
{
    use IdEntity;
    use BlameableEntity;
    use TimestampableEntity;
    use SequenceEntity;
    use ChecksumEntity;

    #[ORM\Column(length: 10)]
    private string $code;

    #[ORM\Column(length: 191)]
    private string $name;

    #[ORM\Column(length: 191)]
    private string $size;

    #[ORM\Column]
    private float $price = 0;

    #[ORM\OneToMany(mappedBy: "judogi", targetEntity: "App\YoshiKan\Domain\Model\Member\Subscription", fetch: "EXTRA_LAZY")]
    #[ORM\JoinColumn(nullable: true)]
    #[ORM\OrderBy(["id" => "ASC"])]
    private ?Collection $subscriptions;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid   $uuid,
        string $code,
        string $name,
        string $size,
        float  $price,
    ) {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->name = $name;
        $this->size = $size;
        $this->price = $price;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid   $uuid,
        string $code,
        string $name,
        string $size,
        float  $price,
    ): self {
        return new self(
            $uuid,
            $code,
            $name,
            $size,
            $price,
        );
    }

    public function change(
        string $code,
        string $name,
        string $size,
        float  $price,
    ): void {
        $this->code = $code;
        $this->name = $name;
        $this->size = $size;
        $this->price = $price;
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

    public function getSize(): string
    {
        return $this->size;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getSubscriptions(): array
    {
        return $this->subscriptions->getValues();
    }
}
