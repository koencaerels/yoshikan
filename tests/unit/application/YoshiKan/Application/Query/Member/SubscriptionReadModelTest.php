<?php

namespace App\Tests\unit\application\YoshiKan\Application\Query\Member;

use App\Tests\unit\application\YoshiKan\Domain\Model\ModelFactory;
use App\YoshiKan\Application\Query\Member\SubscriptionReadModel;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionType;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class SubscriptionReadModelTest extends TestCase
{
    private Subscription $model;

    protected function setUp(): void
    {
        parent::setUp();
        $period = ModelFactory::makePeriod();
        $period->identify(2, Uuid::fromString('c8d6afef-881f-44d0-b721-db517c2334dd'));
        $location = ModelFactory::makeLocation();
        $location->identify(3, Uuid::fromString('eeccc78b-a17b-4513-8523-080fa50dbcd9'));
        $this->model = Subscription::make(
            Uuid::v4(),
            'contactFirstname',
            'contactLastname',
            'contact@email.com',
            'contactPhone',
            'firstname',
            'lastname',
            new \DateTimeImmutable('2023-02-16T08:00:00+01:00'),
            Gender::V,
            SubscriptionType::HALF_YEAR,
            2,
            false,
            true,
            true,
            false,
            'remarks',
            $period,
            $location,
            json_decode(json_encode(ModelFactory::makeSettings()), true),
        );
        $this->model->identify(1, Uuid::fromString('5ba64472-4adf-492a-83df-95ca637d72a1'));
    }

    public function testReadModel(): void
    {
        $readModel = SubscriptionReadModel::hydrateFromModel($this->model);
        $result = json_decode(json_encode($readModel));
        Assert::assertEquals(1, $result->id);
        Assert::assertEquals('5ba64472-4adf-492a-83df-95ca637d72a1', $result->uuid);
        Assert::assertEquals('contactFirstname', $result->contactFirstname);
        Assert::assertEquals('contactLastname', $result->contactLastname);
        Assert::assertEquals('contact@email.com', $result->contactEmail);
        Assert::assertEquals('contactPhone', $result->contactPhone);
        Assert::assertEquals('firstname', $result->firstname);
        Assert::assertEquals('lastname', $result->lastname);
        Assert::assertEquals('2023-02-16T08:00:00+01:00', $result->dateOfBirth);
        Assert::assertEquals('V', $result->gender);
        Assert::assertEquals('half jaar', $result->type);
        Assert::assertEquals(2, $result->numberOfTraining);
        Assert::assertEquals(false, $result->isExtraTraining);
        Assert::assertEquals(true, $result->isNewMember);
        Assert::assertEquals(true, $result->isReductionFamily);
        Assert::assertEquals(false, $result->isJudogiBelt);
        Assert::assertEquals('remarks', $result->remarks);
        Assert::assertEquals(2, $result->period->id);
        Assert::assertEquals(3, $result->location->id);
    }
}
