<?php

namespace App\Tests\unit\application\YoshiKan\Application\Query\Member;

use App\Tests\unit\application\YoshiKan\Domain\Model\ModelFactory;
use App\YoshiKan\Application\Query\Member\Readmodel\GradeLogReadModel;
use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\GradeLog;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class GradeLogReadModelTest extends TestCase
{
    private GradeLog $model;

    protected function setUp(): void
    {
        parent::setUp();
        // from grade
        $fromGrade = Grade::make(Uuid::v4(), 'FG', 'fromGrade', 'white');
        $fromGrade->identify(3, Uuid::fromString('5ba64472-4adf-492a-83df-95ca637d72a1'));
        // to grade
        $toGrade = Grade::make(Uuid::v4(), 'TG', 'toGrade', 'black');
        $toGrade->identify(4, Uuid::fromString('fb0c7a3c-7074-4683-b1b6-8cda0246def6'));
        // default member
        $member = ModelFactory::makeMember();
        $member->identify(10, Uuid::fromString('fa1e689e-d658-4843-b452-192924f5fd95'));
        // grade log model
        $this->model = GradeLog::make(
            Uuid::v4(),
            new \DateTimeImmutable('2023-02-16 08:00:00'),
            'some remarks',
            $member,
            $fromGrade,
            $toGrade
        );
        $this->model->identify(1, Uuid::fromString('b4183a1c-fd26-4472-8e46-dde00b42df5e'));
    }

    public function testReadModel(): void
    {
        $readModel = GradeLogReadModel::hydrateFromModel($this->model);
        $result = json_decode(json_encode($readModel));
        Assert::assertEquals(1, $result->id);
        Assert::assertEquals('b4183a1c-fd26-4472-8e46-dde00b42df5e', $result->uuid);
        Assert::assertEquals('some remarks', $result->remark);
        Assert::assertEquals('2023-02-16T08:00:00+01:00', $result->date);
        Assert::assertEquals(3, $result->fromGrade->id);
        Assert::assertEquals('5ba64472-4adf-492a-83df-95ca637d72a1', $result->fromGrade->uuid);
        Assert::assertEquals(4, $result->toGrade->id);
        Assert::assertEquals('fb0c7a3c-7074-4683-b1b6-8cda0246def6', $result->toGrade->uuid);
    }
}
