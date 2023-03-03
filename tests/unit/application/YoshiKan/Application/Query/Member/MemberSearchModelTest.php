<?php

namespace App\Tests\unit\application\YoshiKan\Application\Query\Member;

use App\YoshiKan\Application\Query\Member\MemberSearchModel;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class MemberSearchModelTest extends TestCase
{
    public function testReadModel(): void
    {
        $model = new \stdClass();
        $model->keyword = 'keyword';
        $model->locationId = 1;
        $model->grade = new \stdClass();
        $model->grade->id = 2;
        $model->yearOfBirth = 3;
        $model->group = new \stdClass();
        $model->group->id = 4;
        $searchModel = MemberSearchModel::hydrateFromJson($model);
        Assert::assertEquals('keyword', $searchModel->getKeyword());
        Assert::assertEquals(1, $searchModel->getLocationId());
        Assert::assertEquals(2, $searchModel->getGradeId());
        Assert::assertEquals(3, $searchModel->getYearOfBirth());
        Assert::assertEquals(4, $searchModel->getGroupId());
    }
}
