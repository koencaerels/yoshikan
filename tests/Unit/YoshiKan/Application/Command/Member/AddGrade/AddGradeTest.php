<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\AddGrade\AddGrade;

it('can add a grade', function () {
    $code = 'GRD123';
    $name = 'Example Grade';
    $color = '#FF0000';

    $addGrade = AddGrade::hydrateFromJson((object) [
        'code' => $code,
        'name' => $name,
        'color' => $color,
    ]);

    expect($addGrade->getCode())->toBe($code)
        ->and($addGrade->getName())->toBe($name)
        ->and($addGrade->getColor())->toBe($color);
})->group('unit');
