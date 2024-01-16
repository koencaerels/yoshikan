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

namespace App\YoshiKan\Application\Command\Member\ChangeMemberDetails;

class ChangeMemberDetails
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected int $id,
        protected string $status,
        protected string $firstname,
        protected string $lastname,
        protected \DateTimeImmutable $dateOfBirth,
        protected string $gender,
        protected int $locationId,
        protected string $nationalRegisterNumber,
        protected string $addressStreet,
        protected string $addressNumber,
        protected string $addressBox,
        protected string $addressZip,
        protected string $addressCity,
        protected string $email,
        protected string $contactFirstname,
        protected string $contactLastname,
        protected string $contactEmail,
        protected string $contactPhone,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromJson(\stdClass $json): self
    {
        return new self(
            $json->id,
            $json->status,
            $json->firstname,
            $json->lastname,
            new \DateTimeImmutable($json->dateOfBirth),
            $json->gender,
            intval($json->locationId),
            $json->nationalRegisterNumber,
            $json->addressStreet,
            $json->addressNumber,
            $json->addressBox,
            $json->addressZip,
            $json->addressCity,
            $json->email,
            $json->contactFirstname,
            $json->contactLastname,
            $json->contactEmail,
            $json->contactPhone
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

    public function getNationalRegisterNumber(): string
    {
        return $this->nationalRegisterNumber;
    }

    public function getAddressStreet(): string
    {
        return $this->addressStreet;
    }

    public function getAddressNumber(): string
    {
        return $this->addressNumber;
    }

    public function getAddressBox(): string
    {
        return $this->addressBox;
    }

    public function getAddressZip(): string
    {
        return $this->addressZip;
    }

    public function getAddressCity(): string
    {
        return $this->addressCity;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getContactFirstname(): string
    {
        return $this->contactFirstname;
    }

    public function getContactLastname(): string
    {
        return $this->contactLastname;
    }

    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }
}
