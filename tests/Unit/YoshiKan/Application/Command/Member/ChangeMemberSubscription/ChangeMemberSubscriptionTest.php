<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ChangeMemberSubscription\ChangeMemberSubscription;

test('change member subscription', function () {
    $memberId = 1;
    $federationId = 2;
    $membershipStart = new DateTimeImmutable('2023-01-01');
    $membershipEnd = new DateTimeImmutable('2023-12-31');
    $licenseStart = new DateTimeImmutable('2023-01-01');
    $licenseEnd = new DateTimeImmutable('2023-12-31');
    $memberShipIsHalfYear = true;
    $numberOfTraining = 10;

    $json = (object) [
        'memberId' => $memberId,
        'federationId' => $federationId,
        'membershipStart' => $membershipStart->format('Y-m-d'),
        'membershipEnd' => $membershipEnd->format('Y-m-d'),
        'licenseStart' => $licenseStart->format('Y-m-d'),
        'licenseEnd' => $licenseEnd->format('Y-m-d'),
        'memberShipIsHalfYear' => $memberShipIsHalfYear,
        'numberOfTraining' => $numberOfTraining,
    ];

    $changeMemberSubscription = ChangeMemberSubscription::hydrateFromJson($json);

    expect($changeMemberSubscription->getMemberId())->toBe($memberId)
        ->and($changeMemberSubscription->getFederationId())->toBe($federationId)
        ->and($changeMemberSubscription->getMembershipStart())->toEqual($membershipStart)
        ->and($changeMemberSubscription->getMembershipEnd())->toEqual($membershipEnd)
        ->and($changeMemberSubscription->getLicenseStart())->toEqual($licenseStart)
        ->and($changeMemberSubscription->getLicenseEnd())->toEqual($licenseEnd)
        ->and($changeMemberSubscription->isMemberShipIsHalfYear())->toBe($memberShipIsHalfYear)
        ->and($changeMemberSubscription->getNumberOfTraining())->toBe($numberOfTraining);
})->group('unit');
