<?php

use App\Tests\Unit\YoshiKan\Domain\Model\ModelFactory;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Message\Message;
use Symfony\Component\Uid\Uuid;

it('can create a message', function () {
    $uuid = Uuid::v4();
    $sendOn = new DateTimeImmutable();
    $message = Message::make(
        uuid: $uuid,
        sendOn: $sendOn,
        fromName: 'John Doe',
        fromEmail: 'john@example.com',
        toName: 'Jane Doe',
        toEmail: 'jane@example.com',
        subject: 'Test Subject',
        message: 'This is a test message.',
    );
    expect($message->getSendOn())->toBe($sendOn)
        ->and($message->getFromName())->toBe('John Doe')
        ->and($message->getFromEmail())->toBe('john@example.com')
        ->and($message->getToName())->toBe('Jane Doe')
        ->and($message->getToEmail())->toBe('jane@example.com')
        ->and($message->getSubject())->toBe('Test Subject')
        ->and($message->getMessage())->toBe('This is a test message.');
});

it('can set and retrieve a member for the message', function () {
    $uuid = Uuid::v4();
    $message = Message::make(
        uuid: $uuid,
        sendOn: new DateTimeImmutable(),
        fromName: 'John Doe',
        fromEmail: 'john@example.com',
        toName: 'Jane Doe',
        toEmail: 'jane@example.com',
        subject: 'Test Subject',
        message: 'This is a test message.',
    );
    $member = ModelFactory::makeMember(Uuid::v4());
    $message->setMember($member);
    expect($message->getMember())->toBeInstanceOf(Member::class);
});

it('can set and retrieve a subscription for the message', function () {
    $uuid = Uuid::v4();
    $message = Message::make(
        uuid: $uuid,
        sendOn: new DateTimeImmutable(),
        fromName: 'John Doe',
        fromEmail: 'john@example.com',
        toName: 'Jane Doe',
        toEmail: 'jane@example.com',
        subject: 'Test Subject',
        message: 'This is a test message.',
    );
    $subscription = ModelFactory::makeSubscription(Uuid::v4());
    $message->setSubscription($subscription);
    expect($message->getSubscription())->toBeInstanceOf(Subscription::class);
});
