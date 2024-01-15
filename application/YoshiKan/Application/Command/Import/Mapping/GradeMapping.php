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

class GradeMapping
{
    public static function getGradeId(?string $srcGrade): int
    {
        if (true === is_null($srcGrade)) {
            return 1;
        }

        switch ($srcGrade) {
            case '1kyu':
                return 5;
            case '2kyu':
                return 7;
            case '3kyu':
                return 4;
            case '4kyu':
                return 3;
            case '5kyu':
                return 2;
            case '1dan':
                return 6;
            case '2dan':
                return 8;
            case '3dan':
                return 9;
            case '4dan':
                return 10;
            case '5dan':
                return 11;
            case '6dan':
                return 12;
            case '7dan':
                return 13;
            default:
                return 1;
        }
    }
}
