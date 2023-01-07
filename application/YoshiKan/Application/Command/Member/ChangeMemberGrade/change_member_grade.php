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
