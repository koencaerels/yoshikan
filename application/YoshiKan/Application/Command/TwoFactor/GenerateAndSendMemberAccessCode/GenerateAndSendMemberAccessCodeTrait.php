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

namespace App\YoshiKan\Application\Command\TwoFactor\GenerateAndSendMemberAccessCode;

use App\YoshiKan\Application\Settings;

trait GenerateAndSendMemberAccessCodeTrait
{
    public function generateAndSendMemberAccessCode(int $userId): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = GenerateAndSendMemberAccessCode::make(
            $userId,
            Settings::FROM_NAME->value,
            Settings::FROM_EMAIL->value,
        );

        $handler = new GenerateAndSendMemberAccessCodeHandler(
            $this->userRepository,
            $this->memberAccessCodeRepository,
            $this->twig,
            $this->mailer,
        );

        $result = $handler->generateAndSend($command);
        $this->entityManager->flush();

        return $result;
    }
}
