<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\OrderGroup\OrderGroup;

it('can create OrderGroup instance', function () {
    $sequence = [1, 2, 3];
    $orderGroup = new OrderGroup($sequence);
    expect($orderGroup->getSequence())->toBe($sequence);
})->group('unit');

it('can hydrate OrderGroup instance from JSON', function () {
    $jsonData = (object) ['sequence' => [4, 5, 6]];
    $orderGroup = OrderGroup::hydrateFromJson($jsonData);
    expect($orderGroup->getSequence())->toBe($jsonData->sequence);
})->group('unit');
