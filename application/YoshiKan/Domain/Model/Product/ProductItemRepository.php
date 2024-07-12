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

use Symfony\Component\Uid\Uuid;

interface ProductItemRepository
{
    public function nextIdentity(): Uuid;

    public function save(ProductItem $model): int;

    public function delete(ProductItem $model): bool;

    public function getById(int $id): ProductItem;

    public function getByUuid(Uuid $uuid): ProductItem;

    public function getAll(): array;
}
