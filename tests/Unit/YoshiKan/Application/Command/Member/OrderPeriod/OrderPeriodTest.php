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
    $sequence = [1, 2, 3];
    $orderPeriod = new OrderPeriod($sequence);
    expect($orderPeriod->getSequence())->toBe($sequence);
})->group('unit');

it('can hydrate OrderPeriod instance from JSON', function () {
    $jsonData = (object) ['sequence' => [4, 5, 6]];
    $orderPeriod = OrderPeriod::hydrateFromJson($jsonData);
    expect($orderPeriod->getSequence())->toBe($jsonData->sequence);
})->group('unit');
