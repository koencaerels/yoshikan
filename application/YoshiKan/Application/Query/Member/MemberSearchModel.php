<?php

namespace App\YoshiKan\Application\Query\Member;

class MemberSearchModel
{

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected string $keyword,
        protected int    $locationId,
        protected int    $gradeId,
        protected int    $yearOfBirth,
    )
    {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from json
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromJson(\stdClass $json): self
    {
        $keyword = $json->keyword;
        $locationId = 0;
        $gradeId = 0;
        $yearOfBirth = 0;
        if (isset($json->locationId)) {
            $locationId = intval($json->locationId);
        }
        if (isset($json->grade)) {
            $gradeId = intval($json->grade->id);
        }
        if (isset($json->yearOfBirth)) {
            $yearOfBirth = intval($json->yearOfBirth);
        }
        return new self(
            $keyword,
            $locationId,
            $gradeId,
            $yearOfBirth
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getKeyword(): string
    {
        return $this->keyword;
    }

    public function getLocationId(): int
    {
        return $this->locationId;
    }

    public function getGradeId(): int
    {
        return $this->gradeId;
    }

    public function getYearOfBirth(): int
    {
        return $this->yearOfBirth;
    }
}
