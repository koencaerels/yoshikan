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
    $sequence = [1, 2, 3];
    $orderLocation = new OrderLocation($sequence);
    expect($orderLocation->getSequence())->toBe($sequence);
})->group('unit');

it('can hydrate OrderLocation instance from JSON', function () {
    $jsonData = (object) ['sequence' => [4, 5, 6]];
    $orderLocation = OrderLocation::hydrateFromJson($jsonData);
    expect($orderLocation->getSequence())->toBe($jsonData->sequence);
})->group('unit');
