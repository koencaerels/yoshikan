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

class WebConfigurationReadModel implements \JsonSerializable
{
    public function __construct(
        protected LocationReadModelCollection $locations,
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
        $json->locations = $this->getLocations()->getCollection();
        $json->activePeriod = $this->getActivePeriod();
        $json->settings = $this->getSettings();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getLocations(): LocationReadModelCollection
    {
        return $this->locations;
    }

    public function getActivePeriod(): PeriodReadModel
    {
        return $this->activePeriod;
    }

    public function getSettings(): SettingsReadModel
    {
        return $this->settings;
    }
}
