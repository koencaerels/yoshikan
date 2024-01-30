<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\OrderLocation\OrderLocation;

it('can create OrderLocation instance', function () {
    // Sample data
    $sequence = [1, 2, 3];

    // Create OrderLocation instance
    $orderLocation = new OrderLocation($sequence);

    // Assertions
    expect($orderLocation->getSequence())->toBe($sequence);
});

it('can hydrate OrderLocation instance from JSON', function () {
    // Sample JSON data
    $jsonData = (object) ['sequence' => [4, 5, 6]];

    // Hydrate OrderLocation instance from JSON
    $orderLocation = OrderLocation::hydrateFromJson($jsonData);

    // Assertions
    expect($orderLocation->getSequence())->toBe($jsonData->sequence);
});
