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
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\FederationRepository::class)]
class Federation
{
    use IdEntity;
    use BlameableEntity;
    use TimestampableEntity;
    use SequenceEntity;
    use ChecksumEntity;

    // -------------------------------------------------------------- attributes
    #[ORM\Column(length: 191)]
    private string $code;

    #[ORM\Column(length: 191)]
    private string $name;

    #[ORM\Column(length: 191)]
    private string $publicLabel;

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

    /**
     * One-To-Many_Bidirectional
     * One Federation has many Subscriptions.
     */
    #[ORM\OneToMany(mappedBy: 'federation', targetEntity: "App\YoshiKan\Domain\Model\Member\Subscription", fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: true)]
    #[ORM\OrderBy(['id' => 'ASC'])]
    private ?Collection $subscriptions;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid $uuid,
        int $sequence,
        string $code,
        string $name,
        int $yearlySubscriptionFee,
        string $publicLabel,
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
        string $publicLabel,
    ): self {
        return new self(
            $uuid,
            $sequence,
            $code,
            $name,
            $yearlySubscriptionFee,
            $publicLabel
        );
    }

    public function change(
        string $code,
        string $name,
        int $yearlySubscriptionFee,
        string $publicLabel,
    ): void {
        $this->code = trim($code);
        $this->name = trim($name);
        $this->yearlySubscriptionFee = $yearlySubscriptionFee;
        $this->publicLabel = trim($publicLabel);
    }

    // —————————————————————————————————————————————————————————————————————————
    // Other Setters
    // —————————————————————————————————————————————————————————————————————————

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

    public function getPublicLabel(): string
    {
        return $this->publicLabel;
    }

    public function getYearlySubscriptionFee(): ?int
    {
        return $this->yearlySubscriptionFee;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Other model getters
    // —————————————————————————————————————————————————————————————————————————
}
