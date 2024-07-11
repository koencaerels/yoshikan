<?php

use App\YoshiKan\Domain\Model\Member\Group;
use Symfony\Component\Uid\Uuid;

it('can create a group', function () {
    $uuid = Uuid::v4();
    $group = Group::make(
        uuid: $uuid,
        code: 'adults',
        name: 'Adults Group',
        minAge: 18,
        maxAge: 99
    );
    expect($group->getCode())->toBe('adults')
        ->and($group->getName())->toBe('Adults Group')
        ->and($group->getMinAge())->toBe(18)
        ->and($group->getMaxAge())->toBe(99);
});

it('can change group attributes', function () {
    $uuid = Uuid::v4();
    $group = Group::make(
        uuid: $uuid,
        code: 'adults',
        name: 'Adults Group',
        minAge: 18,
        maxAge: 99
    );
    $group->change(
        code: 'seniors',
        name: 'Seniors Group',
        minAge: 60,
        maxAge: 99
    );
    expect($group->getCode())->toBe('seniors')
        ->and($group->getName())->toBe('Seniors Group')
        ->and($group->getMinAge())->toBe(60)
        ->and($group->getMaxAge())->toBe(99);
});
