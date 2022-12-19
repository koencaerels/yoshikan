<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\unit\application\YoshiKan\Domain\Model\Common;

use App\YoshiKan\Domain\Model\Common\IdEntity;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class IdEntityTest extends TestCase
{
    public function testEntityIdTrait(): void
    {
        $entityId = new class () {
            use IdEntity;
        };
        $uuid = Uuid::v4();
        $entityId->identify(1, $uuid);
        Assert::assertEquals(1, $entityId->getId());
        Assert::assertEquals($uuid, $entityId->getUuid());
    }
}
