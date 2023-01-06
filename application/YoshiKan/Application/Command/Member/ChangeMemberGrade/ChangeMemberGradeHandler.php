<?php

namespace App\YoshiKan\Application\Command\Member\ChangeMemberGrade;


use App\YoshiKan\Domain\Model\Member\GradeLog;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Infrastructure\Database\Member\GradeLogRepository;


class ChangeMemberGradeHandler
{
    public function __construct(
        protected MemberRepository   $memberRepository,
        protected GradeLogRepository $gradeLogRepository,
        protected GradeRepository    $gradeRepository)
    {
    }

    public function go(ChangeMemberGrade $command): bool
    {
        $member = $this->memberRepository->getById($command->getId());
        $prevGrade = $member->getGrade();
        $grade = $this->gradeRepository->getById($command->getGradeId());
        if ($prevGrade->getId() !== $grade->getId()) {
            $log = GradeLog::make(
                $this->gradeLogRepository->nextIdentity(),
                new \DateTimeImmutable(),
                $command->getRemark(),
                $member,
                $prevGrade,
                $grade
            );
            $this->gradeLogRepository->save($log);
        }
        $member->changeGrade($grade);
        $this->memberRepository->save($member);
        return true;
    }

}
