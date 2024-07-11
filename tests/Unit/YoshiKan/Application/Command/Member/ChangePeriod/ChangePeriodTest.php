<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ChangePeriod\ChangePeriod;

test('change period', function () {
    $id = 1;
    $code = 'ABC';
    $name = 'Test Period';
    $startDate = new DateTimeImmutable('2023-01-01');
    $endDate = new DateTimeImmutable('2023-12-31');
    $isActive = true;

    $json = (object) [
        'id' => $id,
        'code' => $code,
        'name' => $name,
        'startDate' => $startDate->format('Y-m-d'),
        'endDate' => $endDate->format('Y-m-d'),
        'isActive' => $isActive,
    ];

    $changePeriod = ChangePeriod::hydrateFromJson($json);

    expect($changePeriod->getId())->toBe($id)
        ->and($changePeriod->getCode())->toBe($code)
        ->and($changePeriod->getName())->toBe($name)
        ->and($changePeriod->getStartDate())->toEqual($startDate)
        ->and($changePeriod->getEndDate())->toEqual($endDate)
        ->and($changePeriod->isActive())->toBe($isActive);
})->group('unit');
