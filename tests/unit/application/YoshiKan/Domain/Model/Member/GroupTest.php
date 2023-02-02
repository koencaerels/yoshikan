<?php

namespace App\Tests\unit\application\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Member\Group;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class GroupTest extends TestCase
{
    private Group $model;
    private Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuid = Uuid::v4();
        $this->model = Group::make(
            $this->uuid,
            'groupCode',
            'groupName',
            0,
            99,
        );
        $this->model->setChecksum();
    }

    public function testMake(): void
    {
        Assert::assertInstanceOf(Group::class, $this->model);
        Assert::assertEquals($this->uuid, $this->model->getUuid());
        Assert::assertEquals('groupCode', $this->model->getCode());
        Assert::assertEquals('groupName', $this->model->getName());
        Assert::assertEquals(0, $this->model->getMinAge());
        Assert::assertEquals(99, $this->model->getMaxAge());
    }

    public function testChange(): void
    {
        $this->model->change(
            'changedGroupCode',
            'changedGroupName',
            1,
            98,
        );
        $this->model->setChecksum();
        Assert::assertEquals('changedGroupCode', $this->model->getCode());
        Assert::assertEquals('changedGroupName', $this->model->getName());
        Assert::assertEquals(1, $this->model->getMinAge());
        Assert::assertEquals(98, $this->model->getMaxAge());
    }
}
