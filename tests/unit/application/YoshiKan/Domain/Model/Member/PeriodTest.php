<?php

namespace App\Tests\unit\application\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Member\Period;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class PeriodTest extends TestCase
{
    private Period $model;
    private Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuid = Uuid::v4();
        $this->model = Period::make(
            $this->uuid,
            'periodCode',
            'periodName',
            new \DateTimeImmutable('2020-02-20T20:00:00Z'),
            new \DateTimeImmutable('2020-02-20T21:00:00Z'),
        );
        $this->model->setChecksum();
    }

    public function testMake(): void
    {
        Assert::assertInstanceOf(Period::class, $this->model);
        Assert::assertEquals($this->uuid, $this->model->getUuid());
        Assert::assertEquals('periodCode', $this->model->getCode());
        Assert::assertEquals('periodName', $this->model->getName());
        Assert::assertInstanceOf(\DateTimeImmutable::class, $this->model->getStartDate());
        Assert::assertEquals(new \DateTimeImmutable('2020-02-20T20:00:00Z'), $this->model->getStartDate());
        Assert::assertInstanceOf(\DateTimeImmutable::class, $this->model->getEndDate());
        Assert::assertEquals(new \DateTimeImmutable('2020-02-20T21:00:00Z'), $this->model->getEndDate());
    }

    public function testChange(): void
    {
        $this->model->change(
            'changedPeriodCode',
            'changedPeriodName',
            new \DateTimeImmutable('2022-02-20T20:00:00Z'),
            new \DateTimeImmutable('2022-02-20T21:00:00Z'),
        );
        $this->model->setChecksum();
        Assert::assertEquals('changedPeriodCode', $this->model->getCode());
        Assert::assertEquals('changedPeriodName', $this->model->getName());
        Assert::assertInstanceOf(\DateTimeImmutable::class, $this->model->getStartDate());
        Assert::assertEquals(new \DateTimeImmutable('2022-02-20T20:00:00Z'), $this->model->getStartDate());
        Assert::assertInstanceOf(\DateTimeImmutable::class, $this->model->getEndDate());
        Assert::assertEquals(new \DateTimeImmutable('2022-02-20T21:00:00Z'), $this->model->getEndDate());
    }
}
