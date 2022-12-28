<?php

declare(strict_types=1);

namespace App\YoshiKan\Application\Command\Member\AddJudogi;

class AddJudogi
{

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected int    $id,
        protected string $uuid,
        protected string $code,
        protected string $name,
        protected string $size,
        protected float  $price,
    )
    {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromJson($json): self
    {
        return new self(
            $json->id,
            $json->uuid,
            $json->code,
            $json->name,
            $json->size,
            $json->price,
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

    public function getSize(): string
    {
        return $this->size;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

}
