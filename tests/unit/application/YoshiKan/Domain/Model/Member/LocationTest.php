<?php

namespace App\Tests\unit\application\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Member\Location;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class LocationTest extends TestCase
{
    private Location $model;
    private Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuid = Uuid::v4();
        $this->model = Location::make(
            $this->uuid,
            'locationCode',
            'locationName',
        );
        $this->model->setChecksum();
    }

    public function testMake(): void
    {
        Assert::assertInstanceOf(Location::class, $this->model);
        Assert::assertEquals($this->uuid, $this->model->getUuid());
        Assert::assertEquals('locationCode', $this->model->getCode());
        Assert::assertEquals('locationName', $this->model->getName());
    }

    public function testChange(): void
    {
        $this->model->change(
            'changedLocationCode',
            'changedLocationName',
        );
        $this->model->setChecksum();
        Assert::assertEquals('changedLocationCode', $this->model->getCode());
        Assert::assertEquals('changedLocationName', $this->model->getName());
    }
}
