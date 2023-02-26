<?php

namespace App\Tests\unit\application\YoshiKan\Application\Query\Member;

use App\YoshiKan\Application\Query\Member\JudogiReadModel;
use App\YoshiKan\Domain\Model\Member\Judogi;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class JudogiReadModelTest extends TestCase
{
    private Judogi $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = Judogi::make(Uuid::v4(), 'JD', 'JudoGiName', 'size', 20);
        $this->model->identify(1, Uuid::fromString('5ba64472-4adf-492a-83df-95ca637d72a1'));
    }

    public function testReadModel(): void
    {
        $readModel = JudogiReadModel::hydrateFromModel($this->model);
        $result = json_decode(json_encode($readModel));
        Assert::assertEquals(1, $result->id);
        Assert::assertEquals('5ba64472-4adf-492a-83df-95ca637d72a1', $result->uuid);
        Assert::assertEquals('JD', $result->code);
        Assert::assertEquals('JudoGiName', $result->name);
        Assert::assertEquals('size', $result->size);
        Assert::assertEquals(20, $result->price);
    }
}
