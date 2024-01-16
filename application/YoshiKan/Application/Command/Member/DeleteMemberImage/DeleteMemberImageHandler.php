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
        $file = $command->getUploadFolder().$memberImage->getPath();
        if (file_exists($file)) {
            unlink($file);
        }
        $this->memberImageRepository->delete($memberImage);

        return true;
    }
}
