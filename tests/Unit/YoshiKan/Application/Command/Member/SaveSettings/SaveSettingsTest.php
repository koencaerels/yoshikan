<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\SaveSettings\SaveSettings;

it('can hydrate SaveSettings instance from JSON', function () {
    $jsonData = (object) [
        'code' => 'DEF456',
        'yearlyFee2Training' => 120.00,
        'yearlyFee1Training' => 90.00,
        'halfYearlyFee2Training' => 70.00,
        'halfYearlyFee1Training' => 50.00,
        'extraTrainingFee' => 30.00,
        'newMemberSubscriptionFee' => 220.00,
        'newMemberSubscriptionFeeWithoutGuide' => 200.00,
        'familyDiscount' => 15,
    ];
    $settings = SaveSettings::hydrateFromJson($jsonData);
    expect($settings->getCode())->toBe($jsonData->code)
        ->and($settings->getYearlyFee2Training())->toBe($jsonData->yearlyFee2Training)
        ->and($settings->getYearlyFee1Training())->toBe($jsonData->yearlyFee1Training)
        ->and($settings->getHalfYearlyFee2Training())->toBe($jsonData->halfYearlyFee2Training)
        ->and($settings->getHalfYearlyFee1Training())->toBe($jsonData->halfYearlyFee1Training)
        ->and($settings->getExtraTrainingFee())->toBe($jsonData->extraTrainingFee)
        ->and($settings->getNewMemberSubscriptionFee())->toBe($jsonData->newMemberSubscriptionFee)
        ->and($settings->getNewMemberSubscriptionFeeWithoutGuide())->toBe($jsonData->newMemberSubscriptionFeeWithoutGuide)
        ->and($settings->getFamilyDiscount())->toBe($jsonData->familyDiscount);
})->group('unit');
