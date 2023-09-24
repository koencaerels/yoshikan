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
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\SubscriptionItemRepository::class)]
class SubscriptionItem
{
    // -------------------------------------------------------------- attributes
    use IdEntity;
    use SequenceEntity;
    use ChecksumEntity;
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Column(length: 36)]
    private string $type;

    #[ORM\Column(length: 191)]
    private string $name;

    #[ORM\Column]
    private float $price = 0;

    // ---------------------------------------------------------------- associations
    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Subscription", fetch: 'EXTRA_LAZY', inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private Subscription $subscription;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid $uuid,
        SubscriptionItemType $type,
        string $name,
        float $price,
        Subscription $subscription,
    ) {
        $this->uuid = $uuid;
        $this->type = $type->value;
        $this->name = $name;
        $this->price = $price;
        $this->subscription = $subscription;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid $uuid,
        SubscriptionItemType $type,
        string $name,
        float $price,
        Subscription $subscription,
    ): self {
        return new self(
            $uuid,
            $type,
            $name,
            $price,
            $subscription,
        );
    }

    public function change(
        SubscriptionItemType $type,
        string $name,
        float $price,
    ): void {
        $this->type = $type->value;
        $this->name = $name;
        $this->price = $price;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getType(): SubscriptionItemType
    {
        return SubscriptionItemType::from($this->type);
    }

    public function getTypeAsString(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Other model getters
    // —————————————————————————————————————————————————————————————————————————

    public function getSubscription(): Subscription
    {
        return $this->subscription;
    }
}
