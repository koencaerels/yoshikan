<?php

use App\Tests\Unit\YoshiKan\Domain\Model\ModelFactory;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\MemberStatus;
use Symfony\Component\Uid\Uuid;

it('can create a member', function () {
    $uuid = Uuid::v4();
    $grade = ModelFactory::makeGrade(Uuid::v4());
    $location = ModelFactory::makeLocation(Uuid::v4());
    $federation = ModelFactory::makeFederation(Uuid::v4());
    $gender = Gender::M;

    $member = Member::make(
        uuid: $uuid,
        firstname: 'John',
        lastname: 'Doe',
        dateOfBirth: new DateTimeImmutable('1990-01-01'),
        gender: $gender,
        grade: $grade,
        location: $location,
        federation: $federation,
        email: 'john.doe@example.com',
        nationalRegisterNumber: '12345678901',
        addressStreet: 'Main Street',
        addressNumber: '123',
        addressBox: '',
        addressZip: '12345',
        addressCity: 'Anytown',
        numberOfTraining: 10,
    );
    expect($member->getFirstname())->toBe('John')
        ->and($member->getLastname())->toBe('Doe')
        ->and($member->getDateOfBirth())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($member->getGender())->toBe(Gender::M)
        ->and($member->getGrade())->toBe($grade)
        ->and($member->getLocation())->toBe($location)
        ->and($member->getFederation())->toBe($federation)
        ->and($member->getEmail())->toBe('john.doe@example.com')
        ->and($member->getNationalRegisterNumber())->toBe('12345678901')
        ->and($member->getAddressStreet())->toBe('Main Street')
        ->and($member->getAddressNumber())->toBe('123')
        ->and($member->getAddressZip())->toBe('12345')
        ->and($member->getAddressCity())->toBe('Anytown')
        ->and($member->getNumberOfTraining())->toBe(10);
});

it('can change member details', function () {
    $uuid = Uuid::v4();
    $grade = ModelFactory::makeGrade(Uuid::v4());
    $location = ModelFactory::makeLocation(Uuid::v4());
    $federation = ModelFactory::makeFederation(Uuid::v4());
    $gender = Gender::M;
    $member = Member::make(
        uuid: $uuid,
        firstname: 'John',
        lastname: 'Doe',
        dateOfBirth: new DateTimeImmutable('1990-01-01'),
        gender: $gender,
        grade: $grade,
        location: $location,
        federation: $federation,
        email: 'john.doe@example.com',
        nationalRegisterNumber: '12345678901',
        addressStreet: 'Main Street',
        addressNumber: '123',
        addressBox: '',
        addressZip: '12345',
        addressCity: 'Anytown',
        numberOfTraining: 10,
    );
    $member->changeDetails(
        firstname: 'Jane',
        lastname: 'Smith',
        gender: Gender::V,
        dateOfBirth: new DateTimeImmutable('1995-05-05'),
        status: MemberStatus::ACTIVE,
        location: ModelFactory::makeLocation(Uuid::v4()),
        nationalRegisterNumber: '98765432109',
        email: 'jane.smith@example.com',
        addressStreet: 'New Avenue',
        addressNumber: '456',
        addressBox: 'A',
        addressZip: '54321',
        addressCity: 'Newtown',
        contactFirstname: 'John',
        contactLastname: 'Doe',
        contactEmail: 'john.doe@example.com',
        contactPhone: '123456789',
    );
    expect($member->getFirstname())->toBe('Jane')
        ->and($member->getLastname())->toBe('Smith')
        ->and($member->getDateOfBirth())->toBeInstanceOf(DateTimeImmutable::class)
        ->and($member->getGender())->toBe(Gender::V)
        ->and($member->getStatus())->toBe(MemberStatus::ACTIVE)
        ->and($member->getLocation())->not()->toBe($location)
        ->and($member->getNationalRegisterNumber())->toBe('98765432109')
        ->and($member->getEmail())->toBe('jane.smith@example.com')
        ->and($member->getAddressStreet())->toBe('New Avenue')
        ->and($member->getAddressNumber())->toBe('456')
        ->and($member->getAddressZip())->toBe('54321')
        ->and($member->getAddressCity())->toBe('Newtown')
        ->and($member->getContactFirstname())->toBe('John')
        ->and($member->getContactLastname())->toBe('Doe')
        ->and($member->getContactEmail())->toBe('john.doe@example.com')
        ->and($member->getContactPhone())->toBe('123456789');
});
