<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\NewMemberSubscription\NewMemberSubscription;

it('can hydrate NewMemberSubscription from JSON', function () {
    $jsonObject = json_decode('{
        "type": "type",
        "federationId": 123,
        "locationId": 456,
        "contactFirstname": "John",
        "contactLastname": "Doe",
        "contactEmail": "john@example.com",
        "contactPhone": "123456789",
        "addressStreet": "123 Street",
        "addressNumber": "456",
        "addressBox": "Box",
        "addressZip": "12345",
        "addressCity": "City",
        "firstname": "John",
        "lastname": "Doe",
        "email": "john@example.com",
        "nationalRegisterNumber": "12345678901",
        "dateOfBirth": "1990-01-01T00:00:00+00:00",
        "gender": "Male",
        "memberSubscriptionStart": "2024-01-01T00:00:00+00:00",
        "memberSubscriptionStartMM": "01",
        "memberSubscriptionStartYY": "22",
        "memberSubscriptionEnd": "2025-01-01T00:00:00+00:00",
        "memberSubscriptionTotal": 100.50,
        "memberSubscriptionIsPartSubscription": true,
        "memberSubscriptionIsHalfYear": false,
        "memberSubscriptionIsPayed": true,
        "licenseStart": "2024-01-01T00:00:00+00:00",
        "licenseStartMM": "01",
        "licenseStartYY": "22",
        "licenseEnd": "2025-01-01T00:00:00+00:00",
        "licenseTotal": 50.25,
        "licenseIsPartSubscription": false,
        "licenseIsPayed": true,
        "numberOfTraining": 10,
        "isExtraTraining": false,
        "isNewMember": true,
        "isReductionFamily": false,
        "total": 150.75,
        "remarks": "Remarks",
        "isJudogiBelt": true,
        "newMemberFee": 25.00,
        "sendMail": true
    }');

    $newMemberSubscription = NewMemberSubscription::hydrateFromJson($jsonObject);

    expect($newMemberSubscription->getType())->toBe($jsonObject->type)
        ->and($newMemberSubscription->getFederationId())->toBe($jsonObject->federationId)
        ->and($newMemberSubscription->getLocationId())->toBe($jsonObject->locationId)
        ->and($newMemberSubscription->getContactFirstname())->toBe($jsonObject->contactFirstname)
        ->and($newMemberSubscription->getContactLastname())->toBe($jsonObject->contactLastname)
        ->and($newMemberSubscription->getContactEmail())->toBe($jsonObject->contactEmail)
        ->and($newMemberSubscription->getContactPhone())->toBe($jsonObject->contactPhone)
        ->and($newMemberSubscription->getAddressStreet())->toBe($jsonObject->addressStreet)
        ->and($newMemberSubscription->getAddressNumber())->toBe($jsonObject->addressNumber)
        ->and($newMemberSubscription->getAddressBox())->toBe($jsonObject->addressBox)
        ->and($newMemberSubscription->getAddressZip())->toBe($jsonObject->addressZip)
        ->and($newMemberSubscription->getAddressCity())->toBe($jsonObject->addressCity)
        ->and($newMemberSubscription->getFirstname())->toBe($jsonObject->firstname)
        ->and($newMemberSubscription->getLastname())->toBe($jsonObject->lastname)
        ->and($newMemberSubscription->getEmail())->toBe($jsonObject->email)
        ->and($newMemberSubscription->getNationalRegisterNumber())->toBe($jsonObject->nationalRegisterNumber)
        ->and($newMemberSubscription->getDateOfBirth()->format('Y-m-d'))->toBe('1990-01-01')
        ->and($newMemberSubscription->getGender())->toBe($jsonObject->gender)
        ->and($newMemberSubscription->getMemberSubscriptionStart()->format('Y-m-d'))->toBe('2024-01-01')
        ->and($newMemberSubscription->getMemberSubscriptionStartMM())->toBe($jsonObject->memberSubscriptionStartMM)
        ->and($newMemberSubscription->getMemberSubscriptionStartYY())->toBe($jsonObject->memberSubscriptionStartYY)
        ->and($newMemberSubscription->getMemberSubscriptionEnd()->format('Y-m-d'))->toBe('2025-01-01')
        ->and($newMemberSubscription->getMemberSubscriptionTotal())->toBe($jsonObject->memberSubscriptionTotal)
        ->and($newMemberSubscription->isMemberSubscriptionIsPartSubscription())->toBe($jsonObject->memberSubscriptionIsPartSubscription)
        ->and($newMemberSubscription->isMemberSubscriptionIsHalfYear())->toBe($jsonObject->memberSubscriptionIsHalfYear)
        ->and($newMemberSubscription->isMemberSubscriptionIsPayed())->toBe($jsonObject->memberSubscriptionIsPayed)
        ->and($newMemberSubscription->getLicenseStart()->format('Y-m-d'))->toBe('2024-01-01')
        ->and($newMemberSubscription->getLicenseStartMM())->toBe($jsonObject->licenseStartMM)
        ->and($newMemberSubscription->getLicenseStartYY())->toBe($jsonObject->licenseStartYY)
        ->and($newMemberSubscription->getLicenseEnd()->format('Y-m-d'))->toBe('2025-01-01')
        ->and($newMemberSubscription->getLicenseTotal())->toBe($jsonObject->licenseTotal)
        ->and($newMemberSubscription->isLicenseIsPartSubscription())->toBe($jsonObject->licenseIsPartSubscription)
        ->and($newMemberSubscription->isLicenseIsPayed())->toBe($jsonObject->licenseIsPayed)
        ->and($newMemberSubscription->getNumberOfTraining())->toBe($jsonObject->numberOfTraining)
        ->and($newMemberSubscription->isExtraTraining())->toBe($jsonObject->isExtraTraining)
        ->and($newMemberSubscription->isNewMember())->toBe($jsonObject->isNewMember)
        ->and($newMemberSubscription->isReductionFamily())->toBe($jsonObject->isReductionFamily)
        ->and($newMemberSubscription->getTotal())->toBe($jsonObject->total)
        ->and($newMemberSubscription->getRemarks())->toBe($jsonObject->remarks)
        ->and($newMemberSubscription->isJudogiBelt())->toBe($jsonObject->isJudogiBelt)
        ->and($newMemberSubscription->getNewMemberFee())->toBe($jsonObject->newMemberFee)
        ->and($newMemberSubscription->isSendMail())->toBe($jsonObject->sendMail);
})->group('unit');
