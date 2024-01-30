<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ChangeMemberDetails\ChangeMemberDetails;

test('change member details', function () {
    // Arrange
    $id = 1;
    $status = 'active';
    $firstname = 'John';
    $lastname = 'Doe';
    $dateOfBirth = new DateTimeImmutable('1990-01-01');
    $gender = 'male';
    $locationId = 2;
    $nationalRegisterNumber = '1234567890';
    $addressStreet = '123 Main St';
    $addressNumber = '42';
    $addressBox = '';
    $addressZip = '12345';
    $addressCity = 'City';
    $email = 'john@example.com';
    $contactFirstname = 'Jane';
    $contactLastname = 'Doe';
    $contactEmail = 'jane@example.com';
    $contactPhone = '123-456-7890';

    $changeMemberDetails = ChangeMemberDetails::hydrateFromJson((object) [
        'id' => $id,
        'status' => $status,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'dateOfBirth' => $dateOfBirth->format('Y-m-d'), // Format the date as string
        'gender' => $gender,
        'locationId' => $locationId,
        'nationalRegisterNumber' => $nationalRegisterNumber,
        'addressStreet' => $addressStreet,
        'addressNumber' => $addressNumber,
        'addressBox' => $addressBox,
        'addressZip' => $addressZip,
        'addressCity' => $addressCity,
        'email' => $email,
        'contactFirstname' => $contactFirstname,
        'contactLastname' => $contactLastname,
        'contactEmail' => $contactEmail,
        'contactPhone' => $contactPhone,
    ]);

    // Act
    // Access getters to retrieve the values
    $resultId = $changeMemberDetails->getId();
    $resultStatus = $changeMemberDetails->getStatus();
    $resultFirstname = $changeMemberDetails->getFirstname();
    $resultLastname = $changeMemberDetails->getLastname();
    $resultDateOfBirth = $changeMemberDetails->getDateOfBirth();
    $resultGender = $changeMemberDetails->getGender();
    $resultLocationId = $changeMemberDetails->getLocationId();
    $resultNationalRegisterNumber = $changeMemberDetails->getNationalRegisterNumber();
    $resultAddressStreet = $changeMemberDetails->getAddressStreet();
    $resultAddressNumber = $changeMemberDetails->getAddressNumber();
    $resultAddressBox = $changeMemberDetails->getAddressBox();
    $resultAddressZip = $changeMemberDetails->getAddressZip();
    $resultAddressCity = $changeMemberDetails->getAddressCity();
    $resultEmail = $changeMemberDetails->getEmail();
    $resultContactFirstname = $changeMemberDetails->getContactFirstname();
    $resultContactLastname = $changeMemberDetails->getContactLastname();
    $resultContactEmail = $changeMemberDetails->getContactEmail();
    $resultContactPhone = $changeMemberDetails->getContactPhone();

    // Assert
    // Compare each property with the expected values
    expect($resultId)->toBe($id)
        ->and($resultStatus)->toBe($status)
        ->and($resultFirstname)->toBe($firstname)
        ->and($resultLastname)->toBe($lastname)
        ->and($resultDateOfBirth)->toEqual($dateOfBirth)
        ->and($resultGender)->toBe($gender)
        ->and($resultLocationId)->toBe($locationId)
        ->and($resultNationalRegisterNumber)->toBe($nationalRegisterNumber)
        ->and($resultAddressStreet)->toBe($addressStreet)
        ->and($resultAddressNumber)->toBe($addressNumber)
        ->and($resultAddressBox)->toBe($addressBox)
        ->and($resultAddressZip)->toBe($addressZip)
        ->and($resultAddressCity)->toBe($addressCity)
        ->and($resultEmail)->toBe($email)
        ->and($resultContactFirstname)->toBe($contactFirstname)
        ->and($resultContactLastname)->toBe($contactLastname)
        ->and($resultContactEmail)->toBe($contactEmail)
        ->and($resultContactPhone)->toBe($contactPhone);
});
