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

namespace App\YoshiKan\Application\Command\TwoFactor\ValidateMemberAccessCode;

trait ValidateMemberAccessCodeTrait
{
    public function validateMemberAccessCode(int $accessCode, int $userId): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ValidateMemberAccessCode::make($accessCode, $userId);
        $handler = new ValidateMemberAccessCodeHandler(
            $this->userRepository,
            $this->memberAccessCodeRepository,
        );

        $result = $handler->validate($command);
        $this->entityManager->flush();

        return $result;
    }
}
