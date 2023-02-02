<?php

namespace App\Tests\unit\application\YoshiKan\Domain\Model\Member;

use App\Tests\unit\application\YoshiKan\Domain\Model\ModelFactory;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\MemberStatus;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class MemberTest extends TestCase
{
    private Member $model;
    private Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuid = Uuid::v4();
        $this->model = Member::make(
            $this->uuid,
            'firstname',
            'lastname',
            new \DateTimeImmutable('1986-01-23T20:00:00Z'),
            Gender::M,
            ModelFactory::makeGrade(),
            ModelFactory::makeLocation()
        );
        $this->model->setChecksum();
    }

    public function testMake(): void
    {
        Assert::assertInstanceOf(Member::class, $this->model);
        Assert::assertEquals($this->uuid, $this->model->getUuid());
        Assert::assertEquals('firstname', $this->model->getFirstname());
        Assert::assertEquals('lastname', $this->model->getLastname());
        Assert::assertEquals(new \DateTimeImmutable('1986-01-23T20:00:00Z'), $this->model->getDateOfBirth());
        Assert::assertEquals(Gender::M, $this->model->getGender());
        Assert::assertInstanceOf(Location::class, $this->model->getLocation());
        Assert::assertInstanceOf(Grade::class, $this->model->getGrade());
        Assert::assertEquals(MemberStatus::ACTIVE, $this->model->getStatus());
        Assert::assertEquals('', $this->model->getRemarks());
        Assert::assertEquals('', $this->model->getProfileImage());
    }

    public function testChangeDetails(): void
    {
        $this->model->changeDetails(
            'changedFirstname',
            'changedLastname',
            Gender::V,
            new \DateTimeImmutable('1986-01-23T20:00:00Z'),
            MemberStatus::NON_ACTIVE,
            ModelFactory::makeLocation()
        );
        $this->model->setChecksum();
        Assert::assertEquals('changedFirstname', $this->model->getFirstname());
        Assert::assertEquals('changedLastname', $this->model->getLastname());
        Assert::assertEquals(Gender::V, $this->model->getGender());
        Assert::assertEquals(MemberStatus::NON_ACTIVE, $this->model->getStatus());
        Assert::assertInstanceOf(Location::class, $this->model->getLocation());
        Assert::assertEquals(new \DateTimeImmutable('1986-01-23T20:00:00Z'), $this->model->getDateOfBirth());
    }

    public function testChangeGrade(): void
    {
        $this->model->changeGrade(ModelFactory::makeGrade());
        Assert::assertInstanceOf(Grade::class, $this->model->getGrade());
        Assert::assertEquals('gradeName', $this->model->getGrade()->getName());
    }

    public function testChangeRemarks(): void
    {
        $this->model->changeRemarks('some remarks');
        Assert::assertEquals('some remarks', $this->model->getRemarks());
    }

    public function testProfileImage(): void
    {
        $this->model->setProfileImage('profileimage.jpg');
        Assert::assertEquals('profileimage.jpg', $this->model->getProfileImage());
    }
}
