<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\OrderGrade\OrderGrade;

it('can create OrderGrade instance', function () {
    // Sample data
    $sequence = [1, 2, 3];

    // Create OrderGrade instance
    $orderGrade = new OrderGrade($sequence);

    // Assertions
    expect($orderGrade->getSequence())->toBe($sequence);
});

it('can hydrate OrderGrade instance from JSON', function () {
    // Sample JSON data
    $jsonData = (object) ['sequence' => [4, 5, 6]];

    // Hydrate OrderGrade instance from JSON
    $orderGrade = OrderGrade::hydrateFromJson($jsonData);

    // Assertions
    expect($orderGrade->getSequence())->toBe($jsonData->sequence);
});
