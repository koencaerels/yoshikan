<?php

namespace App\Tests\unit\application\YoshiKan\Application\Query\Member;

use App\YoshiKan\Application\Query\Member\Readmodel\GroupReadModel;
use App\YoshiKan\Domain\Model\Member\Group;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class GroupReadModelTest extends TestCase
{
    private Group $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = Group::make(Uuid::v4(), 'GROUP', 'groupName', 10, 20);
        $this->model->identify(1, Uuid::fromString('5ba64472-4adf-492a-83df-95ca637d72a1'));
    }

    public function testReadModel(): void
    {
        $readModel = GroupReadModel::hydrateFromModel($this->model);
        $result = json_decode(json_encode($readModel));
        Assert::assertEquals(1, $result->id);
        Assert::assertEquals('5ba64472-4adf-492a-83df-95ca637d72a1', $result->uuid);
        Assert::assertEquals('GROUP', $result->code);
        Assert::assertEquals('groupName', $result->name);
        Assert::assertEquals(10, $result->minAge);
        Assert::assertEquals(20, $result->maxAge);
    }
}
