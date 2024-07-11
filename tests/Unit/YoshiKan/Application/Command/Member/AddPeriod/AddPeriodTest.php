<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\AddPeriod\AddPeriod;

it('can add a period', function () {
    $code = 'PER123';
    $name = 'Example Period';
    $startDate = new DateTimeImmutable('2024-01-01');
    $endDate = new DateTimeImmutable('2024-12-31');

    $addPeriod = AddPeriod::hydrateFromJson((object) [
        'code' => $code,
        'name' => $name,
        'startDate' => $startDate->format(DateTimeInterface::ATOM),
        'endDate' => $endDate->format(DateTimeInterface::ATOM),
    ]);

    expect($addPeriod->getCode())->toBe($code)
        ->and($addPeriod->getName())->toBe($name)
        ->and($addPeriod->getStartDate()->format(DateTimeInterface::ATOM))->toBe($startDate->format(DateTimeInterface::ATOM))
        ->and($addPeriod->getEndDate()->format(DateTimeInterface::ATOM))->toBe($endDate->format(DateTimeInterface::ATOM));
})->group('unit');
