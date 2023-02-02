<?php

namespace App\Tests\unit\application\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Member\Grade;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class GradeTest extends TestCase
{
    private Grade $model;
    private Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuid = Uuid::v4();
        $this->model = Grade::make(
            $this->uuid,
            'gradeCode',
            'gradeName',
            'gradeColor',
        );
        $this->model->setChecksum();
    }

    public function testMake(): void
    {
        Assert::assertInstanceOf(Grade::class, $this->model);
        Assert::assertEquals($this->uuid, $this->model->getUuid());
        Assert::assertEquals('gradeCode', $this->model->getCode());
        Assert::assertEquals('gradeName', $this->model->getName());
        Assert::assertEquals('gradeColor', $this->model->getColor());
    }

    public function testChange(): void
    {
        $this->model->change(
            'changedGradeCode',
            'changedGradeName',
            'changedGradeColor',
        );
        $this->model->setChecksum();
        Assert::assertEquals('changedGradeCode', $this->model->getCode());
        Assert::assertEquals('changedGradeName', $this->model->getName());
        Assert::assertEquals('changedGradeColor', $this->model->getColor());
    }
}
