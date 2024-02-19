<?php

use App\Tests\Unit\YoshiKan\Domain\Model\ModelFactory;
use App\YoshiKan\Domain\Model\TwoFactor\MemberAccessCode;
use Bolt\Entity\User;
use Symfony\Component\Uid\Uuid;

it('can create a member access code', function () {
    $user = ModelFactory::makeUser(1);
    $uuid = Uuid::v4();
    $code = '123456';
    $accessCode = MemberAccessCode::make($user, $uuid, $code);
    expect($accessCode->getUser())->toBeInstanceOf(User::class)
        ->and($accessCode->getCode())->toBe($code)
        ->and($accessCode->isActive())->toBeTrue()
        ->and($accessCode->getUsedAt())->toBeNull();
});

it('can mark the access code as used', function () {
    $user = ModelFactory::makeUser(1);
    $uuid = Uuid::v4();
    $accessCode = MemberAccessCode::make($user, $uuid, '123456');
    $accessCode->use();
    expect($accessCode->isActive())->toBeFalse()
        ->and($accessCode->getUsedAt())->toBeInstanceOf(DateTimeImmutable::class);
});

it('can invalidate the access code', function () {
    $user = ModelFactory::makeUser(1);
    $uuid = Uuid::v4();
    $accessCode = MemberAccessCode::make($user, $uuid, '123456');
    $accessCode->invalidate();
    expect($accessCode->isActive())->toBeFalse()
        ->and($accessCode->getUsedAt())->toBeNull();
});
