<?php

namespace App\Tests\unit\application\YoshiKan\Domain\Model\Member;

use App\Tests\unit\application\YoshiKan\Domain\Model\ModelFactory;
use App\YoshiKan\Application\Query\Member\Readmodel\SettingsReadModel;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Period;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;
use App\YoshiKan\Domain\Model\Member\SubscriptionType;
use App\YoshiKan\Domain\Model\Product\Judogi;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class SubscriptionTest extends TestCase
{
    private Subscription $model;
    private Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuid = Uuid::v4();
        $this->model = Subscription::make(
            $this->uuid,
            'contactFirstname',
            'contactLastname',
            'contact@email.com',
            'contactPhone',
            'firstname',
            'lastname',
            new \DateTimeImmutable('1986-01-23T20:00:00Z'),
            Gender::M,
            SubscriptionType::FULL_YEAR,
            1,
            false,
            true,
            false,
            true,
            'subscriptionRemarks',
            ModelFactory::makePeriod(),
            ModelFactory::makeLocation(),
            json_decode(json_encode(SettingsReadModel::hydrateFromModel(ModelFactory::makeSettings())), true)
        );
        $this->model->setChecksum();
    }

    public function testMake(): void
    {
        Assert::assertInstanceOf(Subscription::class, $this->model);
        Assert::assertEquals($this->uuid, $this->model->getUuid());
        Assert::assertEquals('contactFirstname', $this->model->getContactFirstname());
        Assert::assertEquals('contactLastname', $this->model->getContactLastname());
        Assert::assertEquals('contact@email.com', $this->model->getContactEmail());
        Assert::assertEquals('contactPhone', $this->model->getContactPhone());
        Assert::assertEquals('firstname', $this->model->getFirstname());
        Assert::assertEquals('lastname', $this->model->getLastname());
        Assert::assertEquals(new \DateTimeImmutable('1986-01-23T20:00:00Z'), $this->model->getDateOfBirth());
        Assert::assertEquals(Gender::M, $this->model->getGender());
        Assert::assertEquals(SubscriptionType::FULL_YEAR, $this->model->getType());
        Assert::assertEquals(1, $this->model->getNumberOfTraining());
        Assert::assertEquals(false, $this->model->isExtraTraining());
        Assert::assertEquals(true, $this->model->isNewMember());
        Assert::assertEquals(false, $this->model->isReductionFamily());
        Assert::assertEquals(true, $this->model->isJudogiBelt());
        Assert::assertEquals('subscriptionRemarks', $this->model->getRemarks());
        Assert::assertInstanceOf(Period::class, $this->model->getPeriod());
        Assert::assertInstanceOf(Location::class, $this->model->getLocation());
        Assert::assertTrue(is_array($this->model->getSettings()));
        Assert::assertEquals(SubscriptionStatus::NEW, $this->model->getStatus());
        Assert::assertEquals(null, $this->model->getMember());
    }

    public function testChange(): void
    {
        $this->model->change(
            'changedContactFirstname',
            'changedContactLastname',
            'changed-contact@email.com',
            'changedContactPhone',
            'changedFirstname',
            'changedLastname',
            new \DateTimeImmutable('1976-01-23T20:00:00Z'),
            Gender::V,
            SubscriptionType::HALF_YEAR,
            2,
            true,
            false,
            true,
            false,
            'changedRemarks',
            120,
            ModelFactory::makeLocation()
        );
        $this->model->setChecksum();
        Assert::assertEquals('changedContactFirstname', $this->model->getContactFirstname());
        Assert::assertEquals('changedContactLastname', $this->model->getContactLastname());
        Assert::assertEquals('changed-contact@email.com', $this->model->getContactEmail());
        Assert::assertEquals('changedContactPhone', $this->model->getContactPhone());
        Assert::assertEquals('changedFirstname', $this->model->getFirstname());
        Assert::assertEquals('changedLastname', $this->model->getLastname());
        Assert::assertEquals(new \DateTimeImmutable('1976-01-23T20:00:00Z'), $this->model->getDateOfBirth());
        Assert::assertEquals(Gender::V, $this->model->getGender());
        Assert::assertEquals(SubscriptionType::HALF_YEAR, $this->model->getType());
        Assert::assertEquals(2, $this->model->getNumberOfTraining());
        Assert::assertEquals(true, $this->model->isExtraTraining());
        Assert::assertEquals(false, $this->model->isNewMember());
        Assert::assertEquals(true, $this->model->isReductionFamily());
        Assert::assertEquals(false, $this->model->isJudogiBelt());
        Assert::assertEquals('changedRemarks', $this->model->getRemarks());
        Assert::assertEquals(120, $this->model->getTotal());
        Assert::assertInstanceOf(Location::class, $this->model->getLocation());
        Assert::assertEquals(SubscriptionStatus::NEW, $this->model->getStatus());
        Assert::assertEquals(null, $this->model->getMember());
    }

    public function testStatusChange(): void
    {
        $this->model->changeStatus(SubscriptionStatus::AWAITING_PAYMENT);
        Assert::assertEquals(SubscriptionStatus::AWAITING_PAYMENT, $this->model->getStatus());
    }

    public function testSetMember(): void
    {
        $this->model->setMember(ModelFactory::makeMember());
        Assert::assertInstanceOf(Member::class, $this->model->getMember());
        Assert::assertEquals('firstname', $this->model->getMember()->getFirstname());
        Assert::assertEquals('lastname', $this->model->getMember()->getLastname());
    }

    public function testSetJudogi(): void
    {
        $this->model->setJudogi(ModelFactory::makeJudogi(), 50.99);
        Assert::assertInstanceOf(Judogi::class, $this->model->getJudogi());
        Assert::assertEquals('judogiName', $this->model->getJudogi()->getName());
        Assert::assertEquals('judogiCode', $this->model->getJudogi()->getCode());
        Assert::assertEquals(50.99, $this->model->getJudogiPrice());
    }

    public function testResetJudogi(): void
    {
        $this->model->resetJudogi();
        Assert::assertEquals(null, $this->model->getJudogi());
        Assert::assertEquals(0, $this->model->getJudogiPrice());
    }

    public function testFlagPaymentOverviewSend(): void
    {
        $this->model->flagPaymentOverviewMailSend();
        Assert::assertEquals(true,$this->model->isPaymentOverviewSend());
    }
}
