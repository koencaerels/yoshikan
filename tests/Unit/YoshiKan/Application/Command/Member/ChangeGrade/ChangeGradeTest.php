<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ChangeGrade\ChangeGrade;

it('can change a grade', function () {
    $id = 1;
    $code = 'GRD123';
    $name = 'Example Grade';
    $color = '#FF0000';

    $changeGrade = ChangeGrade::hydrateFromJson((object) [
        'id' => $id,
        'code' => $code,
        'name' => $name,
        'color' => $color,
    ]);

    expect($changeGrade->getId())->toBe($id)
        ->and($changeGrade->getCode())->toBe($code)
        ->and($changeGrade->getName())->toBe($name)
        ->and($changeGrade->getColor())->toBe($color);
})->group('unit');
