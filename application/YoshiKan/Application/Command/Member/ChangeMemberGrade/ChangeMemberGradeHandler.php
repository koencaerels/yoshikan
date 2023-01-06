<?php

namespace App\YoshiKan\Application\Command\Member\ChangeMemberGrade;


use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;


class ChangeMemberGradeHandler
{
    public function __construct(
        protected MemberRepository $memberRepository,
        protected GradeRepository  $gradeRepository)
    {
    }

    public function go(ChangeMemberGrade $command): bool
    {
        $member = $this->memberRepository->getById($command->getId());
        $grade = $this->gradeRepository->getById($command->getGradeId());

        return true;
    }

}
