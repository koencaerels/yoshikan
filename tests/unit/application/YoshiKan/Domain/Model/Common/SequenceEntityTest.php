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

use App\YoshiKan\Domain\Model\Common\SequenceEntity;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class SequenceEntityTest extends TestCase
{
    public function testSequenceTrait(): void
    {
        $sequenceEntity = new class () {
            use SequenceEntity;
        };
        $sequenceEntity->setSequence(1);
        Assert::assertEquals(1, $sequenceEntity->getSequence());
    }
}
