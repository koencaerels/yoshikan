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

namespace App\YoshiKan\Application\Command\Message\ResendMessage;

trait ResendMessageTrait
{
    public function resendMessage(\stdClass $jsonCommand): bool
    {
        $command = ResendMessage::hydrateFromJson($jsonCommand);
        $command->setFromInfo('Yoshi-Kan', 'no-reply@yoshi-kan.be');

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new ResendMessageHandler($this->messageRepository, $this->mailer);
        $result = $handler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
