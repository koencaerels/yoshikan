<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ChangeGroup\ChangeGroup;

it('can change a group', function () {
    // Arrange
    $id = 1;
    $code = 'GRP123';
    $name = 'Example Group';
    $minAge = 10;
    $maxAge = 20;

    // Act
    $changeGroup = ChangeGroup::hydrateFromJson((object) [
        'id' => $id,
        'code' => $code,
        'name' => $name,
        'minAge' => $minAge,
        'maxAge' => $maxAge,
    ]);

    // Assert
    expect($changeGroup->getId())->toBe($id)
        ->and($changeGroup->getCode())->toBe($code)
        ->and($changeGroup->getName())->toBe($name)
        ->and($changeGroup->getMinAge())->toBe($minAge)
        ->and($changeGroup->getMaxAge())->toBe($maxAge);
});
