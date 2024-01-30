<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\OrderFederation\OrderFederation;

it('can create OrderFederation instance', function () {
    // Sample data
    $sequence = [1, 2, 3];

    // Create OrderFederation instance
    $orderFederation = new OrderFederation($sequence);

    // Assertions
    expect($orderFederation->getSequence())->toBe($sequence);
});

it('can hydrate OrderFederation instance from JSON', function () {
    $jsonData = (object) ['sequence' => [4, 5, 6]];
    $orderFederation = OrderFederation::hydrateFromJson($jsonData);
    expect($orderFederation->getSequence())->toBe($jsonData->sequence);
});
