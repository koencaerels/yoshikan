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
    $sequence = [1, 2, 3];
    $orderFederation = new OrderFederation($sequence);
    expect($orderFederation->getSequence())->toBe($sequence);
})->group('unit');

it('can hydrate OrderFederation instance from JSON', function () {
    $jsonData = (object) ['sequence' => [4, 5, 6]];
    $orderFederation = OrderFederation::hydrateFromJson($jsonData);
    expect($orderFederation->getSequence())->toBe($jsonData->sequence);
})->group('unit');
