<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\OrderPeriod\OrderPeriod;

it('can create OrderPeriod instance', function () {
    // Sample data
    $sequence = [1, 2, 3];

    // Create OrderPeriod instance
    $orderPeriod = new OrderPeriod($sequence);

    // Assertions
    expect($orderPeriod->getSequence())->toBe($sequence);
});

it('can hydrate OrderPeriod instance from JSON', function () {
    // Sample JSON data
    $jsonData = (object) ['sequence' => [4, 5, 6]];

    // Hydrate OrderPeriod instance from JSON
    $orderPeriod = OrderPeriod::hydrateFromJson($jsonData);

    // Assertions
    expect($orderPeriod->getSequence())->toBe($jsonData->sequence);
});
