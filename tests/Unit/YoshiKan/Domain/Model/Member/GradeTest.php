<?php

use App\YoshiKan\Domain\Model\Member\Grade;
use Symfony\Component\Uid\Uuid;

it('can create a grade', function () {
    $uuid = Uuid::v4();
    $grade = Grade::make(
        uuid: $uuid,
        code: '1K',
        name: '1e Kyu',
        color: 'brown'
    );
    expect($grade->getCode())->toBe('1K')
        ->and($grade->getName())->toBe('1e Kyu')
        ->and($grade->getColor())->toBe('brown');
});

it('can change grade attributes', function () {
    $uuid = Uuid::v4();
    $grade = Grade::make(
        uuid: $uuid,
        code: '1K',
        name: '1e Kyu',
        color: 'brown'
    );
    $grade->change(
        code: '2K',
        name: '2e Kyu',
        color: 'green'
    );
    expect($grade->getCode())->toBe('2K')
        ->and($grade->getName())->toBe('2e Kyu')
        ->and($grade->getColor())->toBe('green');
});
