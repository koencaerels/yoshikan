<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ConfirmMemberWebSubscription\ConfirmMemberWebSubscription;

it('can hydrate from JSON', function () {
    $json = (object) [
        'subscriptionId' => 123,
        'memberId' => 456,
        'type' => 'Type',
        'federationId' => 789,
        'locationId' => 101,
        'contactFirstname' => 'John',
        'contactLastname' => 'Doe',
        'contactEmail' => 'john@example.com',
        'contactPhone' => '123456789',
        'addressStreet' => '123 Main St',
        'addressNumber' => 'Apt 101',
        'addressBox' => 'Box 123',
        'addressZip' => '12345',
        'addressCity' => 'City',
        'firstname' => 'Jane',
        'lastname' => 'Doe',
        'email' => 'jane@example.com',
        'nationalRegisterNumber' => '123456789',
        'dateOfBirth' => '1990-01-01',
        'gender' => 'male',
        'memberSubscriptionStart' => '2024-01-01',
        'memberSubscriptionStartMM' => '01',
        'memberSubscriptionStartYY' => '24',
        'memberSubscriptionEnd' => '2024-12-31',
        'memberSubscriptionTotal' => 100.0,
        'memberSubscriptionIsPartSubscription' => true,
        'memberSubscriptionIsHalfYear' => false,
        'memberSubscriptionIsPayed' => true,
        'licenseStart' => '2024-01-01',
        'licenseStartMM' => '01',
        'licenseStartYY' => '24',
        'licenseEnd' => '2024-12-31',
        'licenseTotal' => 50.0,
        'licenseIsPartSubscription' => false,
        'licenseIsPayed' => true,
        'numberOfTraining' => 10,
        'isExtraTraining' => true,
        'isReductionFamily' => false,
        'total' => 150.0,
        'remarks' => 'Remarks',
        'isJudogiBelt' => true,
        'newMemberFee' => 25.0,
        'sendMail' => true,
    ];

    $subscription = ConfirmMemberWebSubscription::hydrateFromJson($json);

    expect($subscription->getSubscriptionId())->toBe(123)
        ->and($subscription->getMemberId())->toBe(456)
        ->and($subscription->getType())->toBe('Type')
        ->and($subscription->getFederationId())->toBe(789)
        ->and($subscription->getLocationId())->toBe(101)
        ->and($subscription->getContactFirstname())->toBe('John')
        ->and($subscription->getContactLastname())->toBe('Doe')
        ->and($subscription->getContactEmail())->toBe('john@example.com')
        ->and($subscription->getContactPhone())->toBe('123456789')
        ->and($subscription->getAddressStreet())->toBe('123 Main St')
        ->and($subscription->getAddressNumber())->toBe('Apt 101')
        ->and($subscription->getAddressBox())->toBe('Box 123')
        ->and($subscription->getAddressZip())->toBe('12345')
        ->and($subscription->getAddressCity())->toBe('City')
        ->and($subscription->getFirstname())->toBe('Jane')
        ->and($subscription->getLastname())->toBe('Doe')
        ->and($subscription->getEmail())->toBe('jane@example.com')
        ->and($subscription->getNationalRegisterNumber())->toBe('123456789')
        ->and($subscription->getDateOfBirth())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($subscription->getDateOfBirth()->format('Y-m-d'))->toBe('1990-01-01')
        ->and($subscription->getGender())->toBe('male')
        ->and($subscription->getMemberSubscriptionStart())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($subscription->getMemberSubscriptionStart()->format('Y-m-d'))->toBe('2024-01-01')
        ->and($subscription->getMemberSubscriptionStartMM())->toBe('01')
        ->and($subscription->getMemberSubscriptionStartYY())->toBe('24')
        ->and($subscription->getMemberSubscriptionEnd())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($subscription->getMemberSubscriptionEnd()->format('Y-m-d'))->toBe('2024-12-31')
        ->and($subscription->getMemberSubscriptionTotal())->toBe(100.0)
        ->and($subscription->isMemberSubscriptionIsPartSubscription())->toBe(true)
        ->and($subscription->isMemberSubscriptionIsHalfYear())->toBe(false)
        ->and($subscription->isMemberSubscriptionIsPayed())->toBe(true)
        ->and($subscription->getLicenseStart())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($subscription->getLicenseStart()->format('Y-m-d'))->toBe('2024-01-01')
        ->and($subscription->getLicenseStartMM())->toBe('01')
        ->and($subscription->getLicenseStartYY())->toBe('24')
        ->and($subscription->getLicenseEnd())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($subscription->getLicenseEnd()->format('Y-m-d'))->toBe('2024-12-31')
        ->and($subscription->getLicenseTotal())->toBe(50.0)
        ->and($subscription->isLicenseIsPartSubscription())->toBe(false)
        ->and($subscription->isLicenseIsPayed())->toBe(true)
        ->and($subscription->getNumberOfTraining())->toBe(10)
        ->and($subscription->isExtraTraining())->toBe(true)
        ->and($subscription->isReductionFamily())->toBe(false)
        ->and($subscription->getTotal())->toBe(150.0)
        ->and($subscription->getRemarks())->toBe('Remarks')
        ->and($subscription->isJudogiBelt())->toBe(true)
        ->and($subscription->getNewMemberFee())->toBe(25.0)
        ->and($subscription->isSendMail())->toBe(true);
})->group('unit');
