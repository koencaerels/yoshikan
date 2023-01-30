<?php

namespace App\YoshiKan\Application\Command\Member\DeleteMemberImage;

use App\YoshiKan\Domain\Model\Member\MemberImageRepository;

class DeleteMemberImageHandler
{
    public function __construct(
        protected MemberImageRepository $memberImageRepository
    ) {
    }

    public function go(DeleteMemberImage $command): bool
    {
        $memberImage = $this->memberImageRepository->getById($command->getId());
        $file = $command->getUploadFolder() . $memberImage->getPath();
        if (file_exists($file)) {
            unlink($file);
        }
        $this->memberImageRepository->delete($memberImage);
        return true;
    }
}
