<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ChangeLocation\ChangeLocation;

it('can change a location', function () {
    // Arrange
    $id = 1;
    $code = 'LOC123';
    $name = 'Example Location';

    // Act
    $changeLocation = ChangeLocation::hydrateFromJson((object) [
        'id' => $id,
        'code' => $code,
        'name' => $name,
    ]);

    // Assert
    expect($changeLocation->getId())->toBe($id)
        ->and($changeLocation->getCode())->toBe($code)
        ->and($changeLocation->getName())->toBe($name);
});
