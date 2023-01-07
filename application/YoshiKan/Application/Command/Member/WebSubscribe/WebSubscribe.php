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

namespace App\YoshiKan\Application\Command\Member\WebSubscribe;

class WebSubscribe
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected int                $periodId,
        protected string             $contactFirstname,
        protected string             $contactLastname,
        protected string             $contactEmail,
        protected string             $contactPhone,
        protected string             $firstname,
        protected string             $lastname,
        protected string             $dateOfBirthDD,
        protected string             $dateOfBirthMM,
        protected string             $dateOfBirthYYYY,
        protected \DateTimeImmutable $dateOfBirth,
        protected string             $gender,
        protected bool               $newMember,
        protected string             $type,
        protected int                $locationId,
        protected int                $numberOfTraining,
        protected bool               $extraTraining,
        protected bool               $reductionFamily,
        protected bool               $judogiBelt,
        protected string             $remarks,
        protected string             $honeyPot
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————
    /**
     * @throws \Exception
     */
    public static function hydrateFromJson($json): self
    {
        return new self(
            intval($json->periodId),
            filter_var(trim($json->contactFirstname), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            filter_var(trim($json->contactLastname), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            filter_var(trim($json->contactEmail), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            filter_var(trim($json->contactPhone), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            filter_var(trim($json->firstname), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            filter_var(trim($json->lastname), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            intval($json->dateOfBirthDD),
            intval($json->dateOfBirthMM),
            intval($json->dateOfBirthYYYY),
            new \DateTimeImmutable($json->dateOfBirth),
            filter_var(trim($json->gender), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            boolval($json->newMember),
            filter_var(trim($json->type), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            intval($json->location),
            intval($json->numberOfTraining),
            boolval($json->extraTraining),
            boolval($json->reductionFamily),
            boolval($json->judogiBelt),
            filter_var(trim($json->remarks), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            filter_var(trim($json->honeyPot), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getPeriodId(): int
    {
        return $this->periodId;
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

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getDateOfBirthDD(): string
    {
        return $this->dateOfBirthDD;
    }

    public function getDateOfBirthMM(): string
    {
        return $this->dateOfBirthMM;
    }

    public function getDateOfBirthYYYY(): string
    {
        return $this->dateOfBirthYYYY;
    }

    public function getDateOfBirth(): \DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function isNewMember(): bool
    {
        return $this->newMember;
    }

    public function getNumberOfTraining(): int
    {
        return $this->numberOfTraining;
    }

    public function isExtraTraining(): bool
    {
        return $this->extraTraining;
    }

    public function isReductionFamily(): bool
    {
        return $this->reductionFamily;
    }

    public function isJudogiBelt(): bool
    {
        return $this->judogiBelt;
    }

    public function getRemarks(): string
    {
        return $this->remarks;
    }

    public function getHoneyPot(): string
    {
        return $this->honeyPot;
    }

    public function getLocationId(): int
    {
        return $this->locationId;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
