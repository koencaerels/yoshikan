<?php

namespace App\Tests\unit\application\YoshiKan\Domain\Model\Member;

use App\Tests\unit\application\YoshiKan\Domain\Model\ModelFactory;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\MemberImage;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class MemberImageTest extends TestCase
{
    private MemberImage $model;
    private Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuid = Uuid::v4();
        $this->model = MemberImage::make(
            $this->uuid,
            'originalName.jpg',
            $this->uuid . '.jpg',
            ModelFactory::makeMember(),
        );
        $this->model->setChecksum();
    }

    public function testMake(): void
    {
        Assert::assertInstanceOf(MemberImage::class, $this->model);
        Assert::assertEquals($this->uuid, $this->model->getUuid());
        Assert::assertEquals('originalName.jpg', $this->model->getOriginalName());
        Assert::assertEquals($this->uuid . '.jpg', $this->model->getPath());
        Assert::assertInstanceOf(Member::class, $this->model->getMember());
        Assert::assertEquals('firstname', $this->model->getMember()->getFirstname());
        Assert::assertEquals('lastname', $this->model->getMember()->getLastname());
    }

}
