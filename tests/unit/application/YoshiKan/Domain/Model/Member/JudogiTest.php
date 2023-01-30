<?php

namespace App\Tests\unit\application\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Member\Judogi;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class JudogiTest extends TestCase
{
    private Judogi $model;
    private Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuid = Uuid::v4();
        $this->model = Judogi::make(
            $this->uuid,
            'judogiCode',
            'judogiName',
            'judogiSize',
            50.50,
        );
        $this->model->setChecksum();
    }

    public function testMake(): void
    {
        Assert::assertInstanceOf(Judogi::class, $this->model);
        Assert::assertEquals($this->uuid, $this->model->getUuid());
        Assert::assertEquals('judogiCode', $this->model->getCode());
        Assert::assertEquals('judogiName', $this->model->getName());
        Assert::assertEquals('judogiSize', $this->model->getSize());
        Assert::assertEquals(50.50, $this->model->getPrice());
    }

    public function testChange(): void
    {
        $this->model->change(
            'changedJudogiCode',
            'changedJudogiName',
            'changedJudogiSize',
            49.50,
        );
        $this->model->setChecksum();
        Assert::assertEquals('changedJudogiCode', $this->model->getCode());
        Assert::assertEquals('changedJudogiName', $this->model->getName());
        Assert::assertEquals('changedJudogiSize', $this->model->getSize());
        Assert::assertEquals(49.50, $this->model->getPrice());
    }
}
