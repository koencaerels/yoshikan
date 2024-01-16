<?php

namespace App\YoshiKan\Application\Command\Message\ResendMessage;

class ResendMessage
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected int $messageId,
        protected string $toEmail,
        protected string $fromName = '',
        protected string $fromEmail = ''
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromJson(\stdClass $json): self
    {
        return new self(
            intval($json->messageId),
            trim($json->toEmail),
        );
    }

    public function setFromInfo(string $fromName, string $fromEmail): void
    {
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getMessageId(): int
    {
        return $this->messageId;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    public function getToEmail(): string
    {
        return $this->toEmail;
    }
}
