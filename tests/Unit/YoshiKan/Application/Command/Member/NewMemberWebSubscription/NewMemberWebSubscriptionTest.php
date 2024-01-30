<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\NewMemberWebSubscription\NewMemberWebSubscription;

it('can hydrate NewMemberWebSubscription from JSON', function () {
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
        "nationalRegisterNumber": "12345678901",
        "dateOfBirth": "1990-01-01T00:00:00+00:00",
        "gender": "Male",
        "memberSubscriptionIsHalfYear": true,
        "numberOfTraining": 10,
        "isExtraTraining": false,
        "isNewMember": true,
        "isReductionFamily": false,
        "total": 150.75,
        "remarks": "Remarks",
        "isJudogiBelt": true,
        "honeyPot": "pot"
    }');

    $newMemberWebSubscription = NewMemberWebSubscription::hydrateFromJson($jsonObject);

    expect($newMemberWebSubscription->getType())->toBe($jsonObject->type)
        ->and($newMemberWebSubscription->getFederationId())->toBe($jsonObject->federationId)
        ->and($newMemberWebSubscription->getLocationId())->toBe($jsonObject->locationId)
        ->and($newMemberWebSubscription->getContactFirstname())->toBe($jsonObject->contactFirstname)
        ->and($newMemberWebSubscription->getContactLastname())->toBe($jsonObject->contactLastname)
        ->and($newMemberWebSubscription->getContactEmail())->toBe($jsonObject->contactEmail)
        ->and($newMemberWebSubscription->getContactPhone())->toBe($jsonObject->contactPhone)
        ->and($newMemberWebSubscription->getAddressStreet())->toBe($jsonObject->addressStreet)
        ->and($newMemberWebSubscription->getAddressNumber())->toBe($jsonObject->addressNumber)
        ->and($newMemberWebSubscription->getAddressBox())->toBe($jsonObject->addressBox)
        ->and($newMemberWebSubscription->getAddressZip())->toBe($jsonObject->addressZip)
        ->and($newMemberWebSubscription->getAddressCity())->toBe($jsonObject->addressCity)
        ->and($newMemberWebSubscription->getFirstname())->toBe($jsonObject->firstname)
        ->and($newMemberWebSubscription->getLastname())->toBe($jsonObject->lastname)
        ->and($newMemberWebSubscription->getNationalRegisterNumber())->toBe($jsonObject->nationalRegisterNumber)
        ->and($newMemberWebSubscription->getDateOfBirth()->format('Y-m-d'))->toBe('1990-01-01')
        ->and($newMemberWebSubscription->getGender())->toBe($jsonObject->gender)
        ->and($newMemberWebSubscription->isMemberSubscriptionIsHalfYear())->toBe($jsonObject->memberSubscriptionIsHalfYear)
        ->and($newMemberWebSubscription->getNumberOfTraining())->toBe($jsonObject->numberOfTraining)
        ->and($newMemberWebSubscription->isExtraTraining())->toBe($jsonObject->isExtraTraining)
        ->and($newMemberWebSubscription->isNewMember())->toBe($jsonObject->isNewMember)
        ->and($newMemberWebSubscription->isReductionFamily())->toBe($jsonObject->isReductionFamily)
        ->and($newMemberWebSubscription->getTotal())->toBe($jsonObject->total)
        ->and($newMemberWebSubscription->getRemarks())->toBe($jsonObject->remarks)
        ->and($newMemberWebSubscription->isJudogiBelt())->toBe($jsonObject->isJudogiBelt)
        ->and($newMemberWebSubscription->getHoneyPot())->toBe($jsonObject->honeyPot);
})->group('unit');
