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
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Product\ProductGroupRepository::class)]
class ProductGroup
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

    #[ORM\OneToMany(mappedBy: 'productGroup', targetEntity: "App\YoshiKan\Domain\Model\Product\Product", fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\OrderBy(['sequence' => 'ASC'])]
    private Collection $products;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid $uuid,
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
        Uuid $uuid,
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

    public function getProducts(): array
    {
        return $this->products->getValues();
    }
}
