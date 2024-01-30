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
    // Sample data
    $sequence = [1, 2, 3];

    // Create OrderGroup instance
    $orderGroup = new OrderGroup($sequence);

    // Assertions
    expect($orderGroup->getSequence())->toBe($sequence);
});

it('can hydrate OrderGroup instance from JSON', function () {
    // Sample JSON data
    $jsonData = (object) ['sequence' => [4, 5, 6]];

    // Hydrate OrderGroup instance from JSON
    $orderGroup = OrderGroup::hydrateFromJson($jsonData);

    // Assertions
    expect($orderGroup->getSequence())->toBe($jsonData->sequence);
});
