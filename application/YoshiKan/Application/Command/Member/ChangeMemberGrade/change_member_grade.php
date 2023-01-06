<?php

namespace App\YoshiKan\Application\Command\Member\ChangeMemberGrade;

trait change_member_grade
{
    public function changeMemberGrade(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeMemberGrade::hydrateFromJson($jsonCommand);
        $commandHandler = new ChangeMemberGradeHandler(
            $this->memberRepository,
            $this->gradeLogRepository,
            $this->gradeRepository
        );
        $result = $commandHandler->go($command);
        $this->entityManager->flush();
        return $result;
    }
}
