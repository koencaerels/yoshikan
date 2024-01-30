<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ChangeFederation\ChangeFederation;

it('can change a federation', function () {
    $id = 1;
    $code = 'FED123';
    $name = 'Example Federation';
    $yearlySubscriptionFee = 100;
    $publicLabel = 'Public Federation';

    $changeFederation = ChangeFederation::hydrateFromJson((object) [
        'id' => $id,
        'code' => $code,
        'name' => $name,
        'yearlySubscriptionFee' => $yearlySubscriptionFee,
        'publicLabel' => $publicLabel,
    ]);

    expect($changeFederation->getId())->toBe($id)
        ->and($changeFederation->getCode())->toBe($code)
        ->and($changeFederation->getName())->toBe($name)
        ->and($changeFederation->getYearlySubscriptionFee())->toBe($yearlySubscriptionFee)
        ->and($changeFederation->getPublicLabel())->toBe($publicLabel);
})->group('unit');
