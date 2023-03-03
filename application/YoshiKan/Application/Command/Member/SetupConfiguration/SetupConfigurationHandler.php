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

namespace App\YoshiKan\Application\Command\Member\SetupConfiguration;

use App\YoshiKan\Domain\Model\Member\Period;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Infrastructure\Database\Member\PeriodRepository;

class SetupConfigurationHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(
        protected PeriodRepository $periodRepository,
        protected SettingsRepository $settingsRepository,
    ) {
    }

    // ———————————————————————————————————————————————————————————————
    // Handle
    // ———————————————————————————————————————————————————————————————

    public function go(SetupConfiguration $command): bool
    {
        // -- make a first period
        $firstPeriod = Period::make(
            $this->periodRepository->nextIdentity(),
            'FIRST',
            'first period',
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );
        $firstPeriod->activate();
        $this->periodRepository->save($firstPeriod);

        // -- make default settings
        $settings = Settings::make(
            $this->settingsRepository->nextIdentity(),
            $command->getCode(),
            260,
            205,
            155,
            130,
            50,
            10,
            10,
        );
        $this->settingsRepository->save($settings);

        return true;
    }
}
