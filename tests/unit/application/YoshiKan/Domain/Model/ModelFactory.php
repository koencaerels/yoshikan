<?php

namespace App\Tests\unit\application\YoshiKan\Domain\Model;

use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Period;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Product\Judogi;
use Symfony\Component\Uid\Uuid;

class ModelFactory
{
    public static function makeMember(): Member
    {
        return Member::make(
            Uuid::v4(),
            'firstname',
            'lastname',
            new \DateTimeImmutable(),
            Gender::M,
            self::makeGrade(),
            self::makeLocation()
        );
    }

    public static function makeGrade(): Grade
    {
        return Grade::make(
            Uuid::v4(),
            'gradeCode',
            'gradeName',
            'gradeColor'
        );
    }

    public static function makeLocation(): Location
    {
        return Location::make(
            Uuid::v4(),
            'locationCode',
            'locationName'
        );
    }

    public static function makePeriod(): Period
    {
        return Period::make(
            Uuid::v4(),
            'periodCode',
            'periodName',
            new \DateTimeImmutable('2020-02-20T20:00:00Z'),
            new \DateTimeImmutable('2020-02-22T20:00:00Z'),
        );
    }

    public static function makeSettings(): Settings
    {
        $settings = Settings::make(
            Uuid::v4(),
            'settingsCode',
            1.1,
            2.2,
            3.3,
            4.4,
            5.5,
            6.6,
            7,
        );
        $settings->identify(1, Uuid::v4());
        return $settings;
    }

    public static function makeJudogi(): Judogi
    {
        return Judogi::make(
            Uuid::v4(),
            'judogiCode',
            'judogiName',
            'judogiSize',
            50.50,
        );
    }
}
