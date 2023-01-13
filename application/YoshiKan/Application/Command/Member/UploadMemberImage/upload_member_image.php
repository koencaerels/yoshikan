<?php

namespace App\YoshiKan\Application\Command\Member\UploadMemberImage;

trait upload_member_image
{
    public function uploadMemberImage(UploadMemberImage $command): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $commandHandler = new UploadMemberImageHandler(
            $this->memberRepository,
            $this->memberImageRepository
        );
        $result = $commandHandler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
