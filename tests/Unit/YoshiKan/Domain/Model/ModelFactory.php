<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Unit\YoshiKan\Domain\Model;

use App\YoshiKan\Domain\Model\Member\Federation;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionType;
use Symfony\Component\Uid\Uuid;

class ModelFactory
{
    public static function makeMember(Uuid $uuid): Member
    {
        return Member::make(
            uuid: $uuid,
            firstname: 'Firstname',
            lastname: 'Lastname',
            dateOfBirth: new \DateTimeImmutable('05/05/2000'),
            gender: Gender::M,
            grade: self::makeGrade($uuid),
            location: self::makeLocation($uuid),
            federation: self::makeFederation($uuid),
            email: 'member@yoshikan.be',
            nationalRegisterNumber: '123467-789-12',
            addressStreet: 'Street',
            addressNumber: '1',
            addressBox: 'A',
            addressZip: '1000',
            addressCity: 'Brussels',
            numberOfTraining: 1,
        );
    }

    public static function makeSubscription(Uuid $uuid): Subscription
    {
        return Subscription::make(
            uuid: $uuid,
            contactFirstname: 'Contact Firstname',
            contactLastname: 'Contact Lastname',
            contactEmail: 'parent@yoshikan.be',
            contactPhone: '0123456789',
            firstname: 'Firstname',
            lastname: 'Lastname',
            dateOfBirth: new \DateTimeImmutable('05/05/2000'),
            gender: Gender::M,
            type: SubscriptionType::NEW_SUBSCRIPTION,
            numberOfTraining: 1,
            isExtraTraining: false,
            isNewMember: true,
            isReductionFamily: false,
            isJudogiBelt: false,
            remarks: 'Remarks',
            location: self::makeLocation($uuid),
            settings: json_decode(json_encode(self::makeSettings($uuid)), true),
            federation: self::makeFederation($uuid),
            memberSubscriptionStart: new \DateTimeImmutable('01/01/2000'),
            memberSubscriptionEnd: new \DateTimeImmutable('01/01/2001'),
            memberSubscriptionTotal: 250,
            memberSubscriptionIsPartSubscription: true,
            memberSubscriptionIsHalfYear: false,
            memberSubscriptionIsPayed: false,
            licenseStart: new \DateTimeImmutable('01/01/2000'),
            licenseEnd: new \DateTimeImmutable('01/01/2001'),
            licenseTotal: 49,
            licenseIsPartSubscription: true,
            licenseIsPayed: false,
            newMemberFee: 10,
        );
    }

    public static function makeSettings(Uuid $uuid): Settings
    {
        return Settings::make(
            uuid: $uuid,
            code: 'settings',
            yearlyFee2Training: 260,
            yearlyFee1Training: 205,
            halfYearlyFee2Training: 155,
            halfYearlyFee1Training: 130,
            extraTrainingFee: 50,
            newMemberSubscriptionFee: 10,
            newMemberSubscriptionFeeWithoutGuide: 5,
            familyDiscount: 10,
        );
    }

    public static function makeFederation(Uuid $uuid): Federation
    {
        return Federation::make(
            uuid: $uuid,
            sequence: 1,
            code: 'JV',
            name: 'Judo Vlaanderen',
            yearlySubscriptionFee: 49,
            publicLabel: 'Competitie',
        );
    }

    public static function makeLocation(Uuid $uuid): Location
    {
        return Location::make(
            uuid: $uuid,
            code: 'DOJO',
            name: 'Dojo',
        );
    }

    public static function makeGrade(Uuid $uuid): Grade
    {
        return Grade::make(
            uuid: $uuid,
            code: '1K',
            name: '1e Kyu',
            color: 'brown',
        );
    }
}
