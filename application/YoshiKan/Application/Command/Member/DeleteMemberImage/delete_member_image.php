<?php

namespace App\YoshiKan\Application\Command\Member\DeleteMemberImage;

trait delete_member_image
{
    public function deleteMemberImage(int $id, string $uploadFolder): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = new DeleteMemberImage($id, $uploadFolder);
        $commandHandler = new DeleteMemberImageHandler($this->memberImageRepository);
        $result = $commandHandler->go($command);

        $this->entityManager->flush();

        return $result;
    }
}
