<?php

namespace App\YoshiKan\Application\Command\Member\UploadProfileImage;

use App\YoshiKan\Application\Command\Member\UploadMemberImage\UploadMemberImageHandler;

trait upload_profile_image
{

    public function uploadProfileImage(UploadProfileImage $command): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $commandHandler = new UploadProfileImageHandler($this->memberRepository);
        $result = $commandHandler->go($command);
        $this->entityManager->flush();

        return $result;
    }

}
