<?php

namespace App\Tests\unit\application\YoshiKan\Application\Query\Member;

use App\YoshiKan\Application\Query\Member\Readmodel\PeriodReadModel;
use App\YoshiKan\Domain\Model\Member\Period;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class PeriodReadModelTest extends TestCase
{
    private Period $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = Period::make(
            Uuid::v4(),
            'PER',
            'Period',
            new \DateTimeImmutable('2023-02-10 08:00:00'),
            new \DateTimeImmutable('2023-02-16 08:00:00')
        );
        $this->model->identify(1, Uuid::fromString('5ba64472-4adf-492a-83df-95ca637d72a1'));
    }

    public function testReadModel(): void
    {
        $readModel = PeriodReadModel::hydrateFromModel($this->model);
        $result = json_decode(json_encode($readModel));
        Assert::assertEquals(1, $result->id);
        Assert::assertEquals('5ba64472-4adf-492a-83df-95ca637d72a1', $result->uuid);
        Assert::assertEquals('PER', $result->code);
        Assert::assertEquals('Period', $result->name);
        Assert::assertEquals('2023-02-10T08:00:00+01:00', $result->startDate);
        Assert::assertEquals('2023-02-16T08:00:00+01:00', $result->endDate);
    }
}
