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

interface ProductItemBatchRepository
{
    public function nextIdentity(): Uuid;

    public function save(ProductItemBatch $model): int;

    public function delete(ProductItemBatch $model): bool;

    public function getById(int $id): ProductItemBatch;

    public function getByUuid(Uuid $uuid): ProductItemBatch;

    public function getAll(): array;
}
