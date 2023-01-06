<?php

namespace App\YoshiKan\Application\Command\Member\ChangeMemberDetails;

trait change_member_details
{
    public function changeMemberDetails(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeMemberDetails::hydrateFromJson($jsonCommand);
        $commandHandler = new ChangeMemberDetailsHandler($this->memberRepository, $this->locationRepository);
        $result = $commandHandler->go($command);
        $this->entityManager->flush();
        return $result;
    }
}
