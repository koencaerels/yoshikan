<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\AddLocation\AddLocation;

it('can add a location', function () {
    // Arrange
    $code = 'LOC123';
    $name = 'Example Location';

    // Act
    $addLocation = AddLocation::hydrateFromJson((object) [
        'code' => $code,
        'name' => $name,
    ]);

    // Assert
    expect($addLocation->getCode())->toBe($code)
        ->and($addLocation->getName())->toBe($name);
});
