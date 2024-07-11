<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\MemberExtendSubscription\MemberExtendSubscription;

it('can extend member subscription', function () {
    $json = (object) [
        'memberId' => 123,
        'federationId' => 456,
        'locationId' => 789,
        'contactFirstname' => 'John',
        'contactLastname' => 'Doe',
        'contactEmail' => 'john@example.com',
        'contactPhone' => '123456789',
        'firstname' => 'Jane',
        'lastname' => 'Doe',
        'dateOfBirth' => '1990-01-01',
        'gender' => 'female',
        'type' => 'regular',
        'memberSubscriptionStart' => '2024-01-01',
        'memberSubscriptionEnd' => '2024-12-31',
        'memberSubscriptionTotal' => 100.0,
        'memberSubscriptionIsPartSubscription' => false,
        'memberSubscriptionIsHalfYear' => false,
        'memberSubscriptionIsPayed' => true,
        'licenseStart' => '2024-01-01',
        'licenseEnd' => '2024-12-31',
        'licenseTotal' => 50.0,
        'licenseIsPartSubscription' => false,
        'licenseIsPayed' => true,
        'numberOfTraining' => 10,
        'isExtraTraining' => true,
        'isNewMember' => false,
        'isReductionFamily' => false,
        'isJudogiBelt' => true,
        'remarks' => 'No remarks',
        'total' => 150.0,
        'sendMail' => true,
    ];

    $memberExtendSubscription = MemberExtendSubscription::hydrateFromJson($json);

    expect($memberExtendSubscription->getMemberId())->toBe(123)
        ->and($memberExtendSubscription->getFederationId())->toBe(456)
        ->and($memberExtendSubscription->getLocationId())->toBe(789)
        ->and($memberExtendSubscription->getContactFirstname())->toBe('John')
        ->and($memberExtendSubscription->getContactLastname())->toBe('Doe')
        ->and($memberExtendSubscription->getContactEmail())->toBe('john@example.com')
        ->and($memberExtendSubscription->getContactPhone())->toBe('123456789')
        ->and($memberExtendSubscription->getFirstname())->toBe('Jane')
        ->and($memberExtendSubscription->getLastname())->toBe('Doe')
        ->and($memberExtendSubscription->getDateOfBirth())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($memberExtendSubscription->getDateOfBirth()->format('Y-m-d'))->toBe('1990-01-01')
        ->and($memberExtendSubscription->getGender())->toBe('female')
        ->and($memberExtendSubscription->getType())->toBe('regular')
        ->and($memberExtendSubscription->getMemberSubscriptionStart())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($memberExtendSubscription->getMemberSubscriptionStart()->format('Y-m-d'))->toBe('2024-01-01')
        ->and($memberExtendSubscription->getMemberSubscriptionEnd())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($memberExtendSubscription->getMemberSubscriptionEnd()->format('Y-m-d'))->toBe('2024-12-31')
        ->and($memberExtendSubscription->getMemberSubscriptionTotal())->toBe(100.0)
        ->and($memberExtendSubscription->isMemberSubscriptionIsPartSubscription())->toBeFalse()
        ->and($memberExtendSubscription->isMemberSubscriptionIsHalfYear())->toBeFalse()
        ->and($memberExtendSubscription->isMemberSubscriptionIsPayed())->toBeTrue()
        ->and($memberExtendSubscription->getLicenseStart())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($memberExtendSubscription->getLicenseEnd())->format('Y-m-d')->toBe('2024-12-31')
        ->and($memberExtendSubscription->getLicenseEnd())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($memberExtendSubscription->getLicenseEnd()->format('Y-m-d'))->toBe('2024-12-31')
        ->and($memberExtendSubscription->getLicenseTotal())->toBe(50.0)
        ->and($memberExtendSubscription->isLicenseIsPartSubscription())->toBeFalse()
        ->and($memberExtendSubscription->isLicenseIsPayed())->toBeTrue()
        ->and($memberExtendSubscription->getNumberOfTraining())->toBe(10)
        ->and($memberExtendSubscription->isExtraTraining())->toBeTrue()
        ->and($memberExtendSubscription->isNewMember())->toBeFalse()
        ->and($memberExtendSubscription->isReductionFamily())->toBeFalse()
        ->and($memberExtendSubscription->isJudogiBelt())->toBeTrue()
        ->and($memberExtendSubscription->getRemarks())->toBe('No remarks')
        ->and($memberExtendSubscription->getTotal())->toBe(150.0)
        ->and($memberExtendSubscription->isSendMail())->toBeTrue();
})->group('unit');
