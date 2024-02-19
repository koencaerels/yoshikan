<?php

use App\Tests\Unit\YoshiKan\Domain\Model\ModelFactory;
use App\YoshiKan\Domain\Model\Member\GradeLog;
use Symfony\Component\Uid\Uuid;

it('can create a grade log', function () {
    $uuid = Uuid::v4();
    $member = ModelFactory::makeMember(Uuid::v4());
    $fromGrade = ModelFactory::makeGrade(Uuid::v4());
    $toGrade = ModelFactory::makeGrade(Uuid::v4());
    $date = new DateTimeImmutable();
    $remark = 'Promoted to next grade';
    $gradeLog = GradeLog::make(
        uuid: $uuid,
        date: $date,
        remark: $remark,
        member: $member,
        fromGrade: $fromGrade,
        toGrade: $toGrade
    );
    expect($gradeLog->getDate())->toBe($date)
        ->and($gradeLog->getRemark())->toBe($remark)
        ->and($gradeLog->getMember())->toBe($member)
        ->and($gradeLog->getFromGrade())->toBe($fromGrade)
        ->and($gradeLog->getToGrade())->toBe($toGrade);
});
