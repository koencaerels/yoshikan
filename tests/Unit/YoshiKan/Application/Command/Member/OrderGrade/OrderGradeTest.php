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
    $sequence = [1, 2, 3];
    $orderGrade = new OrderGrade($sequence);
    expect($orderGrade->getSequence())->toBe($sequence);
})->group('unit');

it('can hydrate OrderGrade instance from JSON', function () {
    $jsonData = (object) ['sequence' => [4, 5, 6]];
    $orderGrade = OrderGrade::hydrateFromJson($jsonData);
    expect($orderGrade->getSequence())->toBe($jsonData->sequence);
})->group('unit');
