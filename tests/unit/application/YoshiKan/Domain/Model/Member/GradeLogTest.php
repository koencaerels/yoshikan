<?php

namespace App\Tests\unit\application\YoshiKan\Domain\Model\Member;

use App\Tests\unit\application\YoshiKan\Domain\Model\ModelFactory;
use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\GradeLog;
use App\YoshiKan\Domain\Model\Member\Member;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class GradeLogTest extends TestCase
{
    private GradeLog $model;
    private Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuid = Uuid::v4();
        $this->model = GradeLog::make(
            $this->uuid,
            new \DateTimeImmutable(),
            'gradeLogRemark',
            ModelFactory::makeMember(),
            ModelFactory::makeGrade(),
            ModelFactory::makeGrade(),
        );
        $this->model->setChecksum();
    }

    public function testMake(): void
    {
        Assert::assertInstanceOf(GradeLog::class, $this->model);
        Assert::assertEquals($this->uuid, $this->model->getUuid());
        Assert::assertInstanceOf(\DateTimeImmutable::class, $this->model->getDate());
        Assert::assertEquals('gradeLogRemark', $this->model->getRemark());
        Assert::assertInstanceOf(Member::class, $this->model->getMember());
        Assert::assertEquals('firstname', $this->model->getMember()->getFirstname());
        Assert::assertEquals('lastname', $this->model->getMember()->getLastname());
        Assert::assertInstanceOf(Grade::class, $this->model->getFromGrade());
        Assert::assertInstanceOf(Grade::class, $this->model->getToGrade());
    }
}
