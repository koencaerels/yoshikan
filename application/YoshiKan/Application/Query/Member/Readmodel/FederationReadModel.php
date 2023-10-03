<?php

namespace App\YoshiKan\Application\Query\Member\Readmodel;

use App\YoshiKan\Domain\Model\Member\Federation;

class FederationReadModel implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int    $id,
        protected string $uuid,
        protected string $code,
        protected string $name,
        protected int    $yearlySubscriptionFee,
        protected string $publicLabel,
    )
    {
    }

    // —————————————————————————————————————————————————————————————————————————
    // What to render as json
    // —————————————————————————————————————————————————————————————————————————

    public function jsonSerialize(): \stdClass
    {
        $json = new \stdClass();
        $json->id = $this->getId();
        $json->uuid = $this->getUuid();
        $json->code = $this->getCode();
        $json->name = $this->getName();
        $json->publicLabel = $this->getPublicLabel();
        $json->yearlySubscriptionFee = $this->getYearlySubscriptionFee();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from model
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromModel(Federation $model): self
    {
        return new self(
            $model->getId(),
            $model->getUuid()->toRfc4122(),
            $model->getCode(),
            $model->getName(),
            $model->getYearlySubscriptionFee(),
            $model->getPublicLabel()
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

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getYearlySubscriptionFee(): int
    {
        return $this->yearlySubscriptionFee;
    }

    public function getPublicLabel(): string
    {
        return $this->publicLabel;
    }

}
