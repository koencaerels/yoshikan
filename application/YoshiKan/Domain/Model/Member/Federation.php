<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Common\ChecksumEntity;
use App\YoshiKan\Domain\Model\Common\IdEntity;
use App\YoshiKan\Domain\Model\Common\SequenceEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\FederationRepository::class)]
class Federation
{
    use IdEntity;
    use SequenceEntity;
    use ChecksumEntity;

    // -------------------------------------------------------------- attributes
    #[ORM\Column(length: 191)]
    private ?string $code = null;

    #[ORM\Column(length: 191)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $yearlySubscriptionFee = null;

    // ---------------------------------------------------------------- associations
    /**
     * One-To-Many_Bidirectional
     * One Federation has many Members.
     */
    #[ORM\OneToMany(mappedBy: 'federation', targetEntity: "App\YoshiKan\Domain\Model\Member\Member", fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: true)]
    #[ORM\OrderBy(['id' => 'ASC'])]
    private ?Collection $members;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid $uuid,
        int $sequence,
        string $code,
        string $name,
        int $yearlySubscriptionFee,
    ) {
        // -------------------------------------------------- set the attributes
        $this->uuid = $uuid;
        $this->sequence = $sequence;
        $this->code = $code;
        $this->name = $name;
        $this->yearlySubscriptionFee = $yearlySubscriptionFee;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid $uuid,
        int $sequence,
        string $code,
        string $name,
        int $yearlySubscriptionFee,
    ): self {
        return new self(
            $uuid,
            $sequence,
            $code,
            $name,
            $yearlySubscriptionFee,
        );
    }

    public function change(
        string $code,
        string $name,
        int $yearlySubscriptionFee,
    ): void {
        $this->code = $code;
        $this->name = $name;
        $this->yearlySubscriptionFee = $yearlySubscriptionFee;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Other Setters
    // —————————————————————————————————————————————————————————————————————————

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getYearlySubscriptionFee(): ?int
    {
        return $this->yearlySubscriptionFee;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Other model getters
    // —————————————————————————————————————————————————————————————————————————

    public function getMember(): ?Member
    {
        return $this->member;
    }
}
