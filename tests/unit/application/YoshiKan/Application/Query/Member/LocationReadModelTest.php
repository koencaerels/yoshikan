<?php

namespace App\Tests\unit\application\YoshiKan\Application\Query\Member;

use App\YoshiKan\Application\Query\Member\LocationReadModel;
use App\YoshiKan\Domain\Model\Member\Location;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class LocationReadModelTest extends TestCase
{
    private Location $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = Location::make(Uuid::v4(), 'LOC', 'Location');
        $this->model->identify(1, Uuid::fromString('5ba64472-4adf-492a-83df-95ca637d72a1'));
    }

    public function testReadModel(): void
    {
        $readModel = LocationReadModel::hydrateFromModel($this->model);
        $result = json_decode(json_encode($readModel));
        Assert::assertEquals(1, $result->id);
        Assert::assertEquals('5ba64472-4adf-492a-83df-95ca637d72a1', $result->uuid);
        Assert::assertEquals('LOC', $result->code);
        Assert::assertEquals('Location', $result->name);
    }
}
