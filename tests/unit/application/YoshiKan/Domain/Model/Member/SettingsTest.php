<?php

namespace App\Tests\unit\application\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Member\Settings;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class SettingsTest extends TestCase
{
    private Settings $model;
    private Uuid $uuid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuid = Uuid::v4();
        $this->model = Settings::make(
            $this->uuid,
            'settingsCode',
            1.1,
            2.2,
            3.3,
            4.4,
            5.5,
            6.6,
            7,
        );
        $this->model->setChecksum();
    }

    public function testMake(): void
    {
        Assert::assertInstanceOf(Settings::class, $this->model);
        Assert::assertEquals($this->uuid, $this->model->getUuid());
        Assert::assertEquals('settingsCode', $this->model->getCode());
        Assert::assertEquals(1.1, $this->model->getYearlyFee2Training());
        Assert::assertEquals(2.2, $this->model->getYearlyFee1Training());
        Assert::assertEquals(3.3, $this->model->getHalfYearlyFee2Training());
        Assert::assertEquals(4.4, $this->model->getHalfYearlyFee1Training());
        Assert::assertEquals(5.5, $this->model->getExtraTrainingFee());
        Assert::assertEquals(6.6, $this->model->getNewMemberSubscriptionFee());
        Assert::assertEquals(7, $this->model->getFamilyDiscount());
    }

    public function testChange(): void
    {
        $this->model->change(
            1.2,
            2.3,
            3.4,
            4.5,
            5.6,
            6.7,
            7,
        );
        $this->model->setChecksum();
        Assert::assertEquals(1.2, $this->model->getYearlyFee2Training());
        Assert::assertEquals(2.3, $this->model->getYearlyFee1Training());
        Assert::assertEquals(3.4, $this->model->getHalfYearlyFee2Training());
        Assert::assertEquals(4.5, $this->model->getHalfYearlyFee1Training());
        Assert::assertEquals(5.6, $this->model->getExtraTrainingFee());
        Assert::assertEquals(6.7, $this->model->getNewMemberSubscriptionFee());
        Assert::assertEquals(7, $this->model->getFamilyDiscount());
    }

}
