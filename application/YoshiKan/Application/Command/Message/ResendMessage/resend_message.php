<?php

namespace App\YoshiKan\Application\Command\Message\ResendMessage;

trait resend_message
{
    public function resendMessage(\stdClass $jsonCommand): bool
    {
        $command = ResendMessage::hydrateFromJson($jsonCommand);
        $command->setFromInfo(  'Yoshi-Kan', 'no-reply@yoshi-kan.be');

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new ResendMessageHandler($this->messageRepository, $this->mailer);
        $result = $handler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
