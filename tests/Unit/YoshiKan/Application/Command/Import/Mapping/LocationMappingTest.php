<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Import\Mapping\LocationMapping;

it('can map locations to location IDs', function () {
    expect(LocationMapping::getLocationId('HOFSTADE'))->toBe(1)
        ->and(LocationMapping::getLocationId('HAACHT'))->toBe(2)
        ->and(LocationMapping::getLocationId('HERSELT'))->toBe(4)
        ->and(LocationMapping::getLocationId('HEIST-OP-DEN-BERG'))->toBe(3)
        ->and(LocationMapping::getLocationId('unknown'))->toBe(3);
})->group('location');
