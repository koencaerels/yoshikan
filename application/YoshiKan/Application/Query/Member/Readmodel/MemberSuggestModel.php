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

namespace App\YoshiKan\Application\Query\Member\Readmodel;

class MemberSuggestModel
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected string $firstname,
        protected string $lastname,
        protected \DateTimeImmutable $dateOfBirth,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from json
    // —————————————————————————————————————————————————————————————————————————
    /**
     * @throws \Exception
     */
    public static function hydrateFromJson(\stdClass $json): self
    {
        return new self(
            $json->firstname,
            $json->lastname,
            new \DateTimeImmutable($json->dateOfBirth),
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

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
}
