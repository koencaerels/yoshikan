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

namespace App\YoshiKan\Application\Query\Product\Readmodel;

use App\YoshiKan\Domain\Model\Product\ProductItem;

class ProductItemReadModel implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int $id,
        protected string $uuid,
        protected string $name,
        protected float $price,
        protected ProductItemBatchReadModelCollection $productItemBatches,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // What to render as json
    // —————————————————————————————————————————————————————————————————————————

    public function jsonSerialize(): \stdClass
    {
        $json = new \stdClass();
        $json->id = $this->getId();
        $json->uuid = $this->getUuid();
        $json->name = $this->getName();
        $json->price = $this->getPrice();
        $json->productItemBatches = $this->getProductItemBatches();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from model
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromModel(ProductItem $model): self
    {
        $productItemBatches = new ProductItemBatchReadModelCollection([]);
        foreach ($model->getBatchItems() as $productItemBatch) {
            $productItemBatches->addItem(ProductItemBatchReadModel::hydrateFromModel($productItemBatch));
        }

        return new self(
            $model->getId(),
            $model->getUuid()->toRfc4122(),
            $model->getName(),
            $model->getPrice(),
            $productItemBatches,
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getProductItemBatches(): array
    {
        return $this->productItemBatches->getCollection();
    }
}
