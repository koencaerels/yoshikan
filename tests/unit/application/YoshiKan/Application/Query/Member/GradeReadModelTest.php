<?php

namespace App\Tests\unit\application\YoshiKan\Application\Query\Member;

use App\YoshiKan\Application\Query\Member\GradeReadModel;
use App\YoshiKan\Domain\Model\Member\Grade;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class GradeReadModelTest extends TestCase
{
    private Grade $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = Grade::make(Uuid::v4(), 'FG', 'grade', 'white');
        $this->model->identify(1, Uuid::fromString('5ba64472-4adf-492a-83df-95ca637d72a1'));
    }

    public function testReadModel(): void
    {
        $readModel = GradeReadModel::hydrateFromModel($this->model);
        $result = json_decode(json_encode($readModel));
        Assert::assertEquals(1, $result->id);
        Assert::assertEquals('5ba64472-4adf-492a-83df-95ca637d72a1', $result->uuid);
        Assert::assertEquals('FG', $result->code);
        Assert::assertEquals('grade', $result->name);
        Assert::assertEquals('white', $result->color);
    }

}
