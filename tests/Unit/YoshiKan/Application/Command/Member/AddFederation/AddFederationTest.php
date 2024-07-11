<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\AddFederation\AddFederation;

it('can add a federation', function () {
    $code = 'FED123';
    $name = 'Example Federation';
    $yearlySubscriptionFee = 100;
    $publicLabel = 'Public Federation';

    $addFederation = AddFederation::hydrateFromJson((object) [
        'code' => $code,
        'name' => $name,
        'yearlySubscriptionFee' => $yearlySubscriptionFee,
        'publicLabel' => $publicLabel,
    ]);

    expect($addFederation->getCode())->toBe($code)
        ->and($addFederation->getName())->toBe($name)
        ->and($addFederation->getYearlySubscriptionFee())->toBe($yearlySubscriptionFee)
        ->and($addFederation->getPublicLabel())->toBe($publicLabel);
})->group('unit');
