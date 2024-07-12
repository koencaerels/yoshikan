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
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Product\ProductRepository::class)]
class Product
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

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Product\ProductGroup", fetch: 'EXTRA_LAZY', inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ProductGroup $productGroup;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: "App\YoshiKan\Domain\Model\Product\ProductItem", fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\OrderBy(['sequence' => 'ASC'])]
    private Collection $productItems;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid $uuid,
        ProductGroup $productGroup,
        string $code,
        string $name,
    ) {
        $this->uuid = $uuid;
        $this->productGroup = $productGroup;
        $this->code = $code;
        $this->name = $name;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid $uuid,
        ProductGroup $productGroup,
        string $code,
        string $name,
    ): self {
        return new self(
            uuid: $uuid,
            productGroup: $productGroup,
            code: $code,
            name: $name,
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

    public function getProductGroup(): ProductGroup
    {
        return $this->productGroup;
    }

    public function getProductItems(): array
    {
        return $this->productItems->getValues();
    }
}
