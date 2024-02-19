<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Domain\Model\Common\IdEntity;
use Symfony\Component\Uid\Uuid;

it('creates identifiers for an object', function () {
    $entityId = new class() {
        use IdEntity;
    };
    $uuid = Uuid::v4();
    $entityId->identify(1, $uuid);

    expect($entityId->getId())->toBe(1)
        ->and($entityId->getUuid())->toBe($uuid);
})->group('unit');
