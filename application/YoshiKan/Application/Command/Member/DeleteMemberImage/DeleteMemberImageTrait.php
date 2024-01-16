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

trait DeleteMemberImageTrait
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
