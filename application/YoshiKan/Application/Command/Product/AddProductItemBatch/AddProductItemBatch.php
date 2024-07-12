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

namespace App\YoshiKan\Application\Command\Product\AddProductItemBatch;

class AddProductItemBatch
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected string $code,
        protected string $name,
        protected float $cost,
        protected int $stock,
        protected int $productItemId,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromJson(\stdClass $json): self
    {
        return new self(
            $json->code,
            $json->name,
            $json->cost,
            $json->stock,
            $json->productItemId,
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

    public function getCost(): float
    {
        return $this->cost;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getProductItemId(): int
    {
        return $this->productItemId;
    }
}
