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

interface ProductGroupRepository
{
    public function nextIdentity(): Uuid;

    public function save(ProductGroup $model): int;

    public function delete(ProductGroup $model): bool;

    public function getById(int $id): ProductGroup;

    public function getByUuid(Uuid $uuid): ProductGroup;

    public function getAll(): array;
}
