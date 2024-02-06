<?php

use App\YoshiKan\Domain\Model\Member\Federation;
use Symfony\Component\Uid\Uuid;

it('can create a federation', function () {
    $uuid = Uuid::v4();
    $federation = Federation::make(
        uuid: $uuid,
        sequence: 1,
        code: 'JV',
        name: 'Judo Vlaanderen',
        yearlySubscriptionFee: 49,
        publicLabel: 'Competitie'
    );
    expect($federation->getCode())->toBe('JV')
        ->and($federation->getName())->toBe('Judo Vlaanderen')
        ->and($federation->getYearlySubscriptionFee())->toBe(49)
        ->and($federation->getPublicLabel())->toBe('Competitie');
});

it('can change federation attributes', function () {
    $uuid = Uuid::v4();
    $federation = Federation::make(
        uuid: $uuid,
        sequence: 1,
        code: 'JV',
        name: 'Judo Vlaanderen',
        yearlySubscriptionFee: 49,
        publicLabel: 'Competitie'
    );
    $federation->change(
        code: 'JJ',
        name: 'Judo Japan',
        yearlySubscriptionFee: 59,
        publicLabel: 'Competition'
    );
    expect($federation->getCode())->toBe('JJ')
        ->and($federation->getName())->toBe('Judo Japan')
        ->and($federation->getYearlySubscriptionFee())->toBe(59)
        ->and($federation->getPublicLabel())->toBe('Competition');
});
