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

namespace App\YoshiKan\Application\Query\Message\Readmodel;

use App\YoshiKan\Domain\Model\Message\Message;

class MessageReadModel implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————
    public function __construct(
        protected int $id,
        protected string $uuid,
        protected \DateTimeImmutable $sendOn,
        protected string $fromName,
        protected string $fromEmail,
        protected string $toName,
        protected string $toEmail,
        protected string $subject,
        protected string $message,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // What to render as json
    // —————————————————————————————————————————————————————————————————————————

    public function jsonSerialize(): \stdClass
    {
        $json = new \stdClass();
        $json->id = $this->getId();
        $json->uuid = $this->getUuid();
        $json->sendOn = $this->getSendOn()->format(\DateTimeInterface::ATOM);
        $json->fromName = $this->getFromName();
        $json->fromEmail = $this->getFromEmail();
        $json->toName = $this->getToName();
        $json->toEmail = $this->getToEmail();
        $json->subject = $this->getSubject();
        $json->message = $this->getMessage();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from model
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromModel(Message $model): self
    {
        return new self(
            $model->getId(),
            $model->getUuid()->toRfc4122(),
            $model->getSendOn(),
            $model->getFromName(),
            $model->getFromEmail(),
            $model->getToName(),
            $model->getToEmail(),
            $model->getSubject(),
            $model->getMessage(),
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getSendOn(): \DateTimeImmutable
    {
        return $this->sendOn;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    public function getToName(): string
    {
        return $this->toName;
    }

    public function getToEmail(): string
    {
        return $this->toEmail;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
