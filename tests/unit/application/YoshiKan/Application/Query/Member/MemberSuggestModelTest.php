<?php

namespace App\Tests\unit\application\YoshiKan\Application\Query\Member;

use App\YoshiKan\Application\Query\Member\MemberSuggestModel;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class MemberSuggestModelTest extends TestCase
{

    public function testReadModel(): void
    {
        $model = new \stdClass();
        $model->firstname = "firstname";
        $model->lastname = "lastname";
        $model->dateOfBirth = "2023-02-16 08:00:00";
        $suggestModel = MemberSuggestModel::hydrateFromJson($model);
        Assert::assertEquals("firstname", $suggestModel->getFirstname());
        Assert::assertEquals("lastname", $suggestModel->getLastname());
        Assert::assertEquals(new \DateTimeImmutable('2023-02-16 08:00:00'), $suggestModel->getDateOfBirth());
    }

}
