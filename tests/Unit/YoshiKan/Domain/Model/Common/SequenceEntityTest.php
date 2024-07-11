<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Domain\Model\Common\SequenceEntity;

it('creates sequences for an object', function () {
    $sequenceEntity = new class() {
        use SequenceEntity;
    };
    $sequenceEntity->setSequence(1);
    expect($sequenceEntity->getSequence())->toBe(1);
})->group('unit');
