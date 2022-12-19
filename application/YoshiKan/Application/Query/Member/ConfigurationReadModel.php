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

namespace App\YoshiKan\Application\Query\Member;

class ConfigurationReadModel implements \JsonSerializable
{
    public function __construct(
        protected GradeReadModelCollection $grades,
        protected LocationReadModelCollection $locations,
        protected GroupReadModelCollection $groups,
        protected PeriodReadModelCollection $periods,
        protected PeriodReadModel $activePeriod,
        protected SettingsReadModel $settings
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // What to render as json
    // —————————————————————————————————————————————————————————————————————————

    public function jsonSerialize(): \stdClass
    {
        $json = new \stdClass();
        $json->grades = $this->getGrades()->getCollection();
        $json->locations = $this->getLocations()->getCollection();
        $json->groups = $this->getGroups()->getCollection();
        $json->periods = $this->getPeriods()->getCollection();
        $json->activePeriod = $this->getActivePeriod();
        $json->settings = $this->getSettings();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getGrades(): GradeReadModelCollection
    {
        return $this->grades;
    }

    public function getLocations(): LocationReadModelCollection
    {
        return $this->locations;
    }

    public function getGroups(): GroupReadModelCollection
    {
        return $this->groups;
    }

    public function getActivePeriod(): PeriodReadModel
    {
        return $this->activePeriod;
    }

    public function getSettings(): SettingsReadModel
    {
        return $this->settings;
    }

    public function getPeriods(): PeriodReadModelCollection
    {
        return $this->periods;
    }
}
