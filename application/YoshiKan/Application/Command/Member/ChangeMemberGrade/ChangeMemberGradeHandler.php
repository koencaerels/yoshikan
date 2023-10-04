<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\YoshiKan\Application\Command\Member\ChangeMemberGrade;

use App\YoshiKan\Domain\Model\Member\GradeLog;
use App\YoshiKan\Domain\Model\Member\GradeLogRepository;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;

class ChangeMemberGradeHandler
{
    public function __construct(
        protected MemberRepository $memberRepository,
        protected GradeLogRepository $gradeLogRepository,
        protected GradeRepository $gradeRepository)
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
