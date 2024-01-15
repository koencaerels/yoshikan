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

namespace App\YoshiKan\Application\Command\Import\Mapping;

class LocationMapping
{

    public static function getLocationId(string $srcLocation): int
    {
        switch ($srcLocation) {
            case 'HOFSTADE':
                return 1;
            case 'HAACHT':
                return 2;
            case 'HERSELT':
                return 4;
            default:
                return 3;
        }
    }
}
