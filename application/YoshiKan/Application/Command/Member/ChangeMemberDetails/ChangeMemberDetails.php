<?php

namespace App\YoshiKan\Application\Command\Member\ChangeMemberDetails;

class ChangeMemberDetails
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected int                $id,
        protected string             $status,
        protected string             $firstname,
        protected string             $lastname,
        protected \DateTimeImmutable $dateOfBirth,
        protected string             $gender,
        protected int                $locationId,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromJson($json): self
    {
        return new self(
            $json->id,
            $json->status,
            $json->firstname,
            $json->lastname,
            new \DateTimeImmutable($json->dateOfBirth),
            $json->gender,
            intval($json->locationId),
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getDateOfBirth(): \DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getLocationId(): int
    {
        return $this->locationId;
    }
}
