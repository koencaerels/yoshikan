<?php

use App\YoshiKan\Domain\Model\Member\Location;
use Symfony\Component\Uid\Uuid;

it('can create a location', function () {
    $uuid = Uuid::v4();
    $location = Location::make(
        uuid: $uuid,
        code: 'dojo',
        name: 'Dojo Location'
    );
    expect($location->getCode())->toBe('dojo')
        ->and($location->getName())->toBe('Dojo Location');
});

it('can change location attributes', function () {
    $uuid = Uuid::v4();
    $location = Location::make(
        uuid: $uuid,
        code: 'dojo',
        name: 'Dojo Location'
    );
    $location->change(
        code: 'gym',
        name: 'Gym Location'
    );
    expect($location->getCode())->toBe('gym')
        ->and($location->getName())->toBe('Gym Location');
});
