<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Import\Mapping\GradeMapping;

it('can map grades to grade IDs', function () {
    // Assert
    expect(GradeMapping::getGradeId(null))->toBe(1)
        ->and(GradeMapping::getGradeId('1kyu'))->toBe(5)
        ->and(GradeMapping::getGradeId('2kyu'))->toBe(7)
        ->and(GradeMapping::getGradeId('3kyu'))->toBe(4)
        ->and(GradeMapping::getGradeId('4kyu'))->toBe(3)
        ->and(GradeMapping::getGradeId('5kyu'))->toBe(2)
        ->and(GradeMapping::getGradeId('1dan'))->toBe(6)
        ->and(GradeMapping::getGradeId('2dan'))->toBe(8)
        ->and(GradeMapping::getGradeId('3dan'))->toBe(9)
        ->and(GradeMapping::getGradeId('4dan'))->toBe(10)
        ->and(GradeMapping::getGradeId('5dan'))->toBe(11)
        ->and(GradeMapping::getGradeId('6dan'))->toBe(12)
        ->and(GradeMapping::getGradeId('7dan'))->toBe(13)
        ->and(GradeMapping::getGradeId('unknown'))->toBe(1);
})->group('unit');
