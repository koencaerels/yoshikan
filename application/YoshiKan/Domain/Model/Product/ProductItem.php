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
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Product\ProductItemRepository::class)]
class ProductItem
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
    private float $price;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Product\Product", fetch: 'EXTRA_LAZY', inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    #[ORM\OneToMany(mappedBy: 'productItem', targetEntity: "App\YoshiKan\Domain\Model\Product\ProductItemBatch", fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\OrderBy(['sequence' => 'ASC'])]
    private Collection $batchItems;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid $uuid,
        Product $product,
        string $code,
        string $name,
        float $price,
    ) {
        $this->uuid = $uuid;
        $this->product = $product;
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid $uuid,
        Product $product,
        string $code,
        string $name,
        float $price,
    ): self {
        return new self(
            uuid: $uuid,
            product: $product,
            code: $code,
            name: $name,
            price: $price
        );
    }

    public function change(
        string $code,
        string $name,
        float $price,
    ): void {
        $this->code = $code;
        $this->name = $name;
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

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getBatchItems(): array
    {
        return $this->batchItems->getValues();
    }
}
