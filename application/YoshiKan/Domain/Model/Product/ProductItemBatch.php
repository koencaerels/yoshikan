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

namespace App\YoshiKan\Domain\Model\Product;

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
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Product\ProductItemBatchRepository::class)]
class ProductItemBatch
{
    use IdEntity;
    use BlameableEntity;
    use TimestampableEntity;
    use SequenceEntity;
    use ChecksumEntity;

    #[ORM\Column(length: 191)]
    private string $code;

    #[ORM\Column(length: 191)]
    private string $name;

    #[ORM\Column]
    private int $stock;

    #[ORM\Column]
    private float $cost;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Product\ProductItem", fetch: 'EXTRA_LAZY', inversedBy: 'batchItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ProductItem $productItem;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid $uuid,
        ProductItem $productItem,
        string $code,
        string $name,
        int $stock,
        float $cost,
    ) {
        $this->uuid = $uuid;
        $this->productItem = $productItem;
        $this->code = $code;
        $this->name = $name;
        $this->stock = $stock;
        $this->cost = $cost;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid $uuid,
        ProductItem $productItem,
        string $code,
        string $name,
        int $stock,
        float $cost,
    ): self {
        return new self(
            uuid: $uuid,
            productItem: $productItem,
            code: $code,
            name: $name,
            stock: $stock,
            cost: $cost
        );
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

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    public function getProductItem(): ProductItem
    {
        return $this->productItem;
    }
}
