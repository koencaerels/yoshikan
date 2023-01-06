<?php

namespace App\YoshiKan\Application\Command\Member\ChangeMemberRemarks;

trait change_member_remarks
{
    public function changeMemberRemarks(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeMemberRemarks::hydrateFromJson($jsonCommand);
        $commandHandler = new ChangeMemberRemarksHandler($this->memberRepository);
        $result = $commandHandler->go($command);
        $this->entityManager->flush();
        return $result;
    }
}
