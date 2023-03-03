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

namespace App\YoshiKan\Application\Command\Member\SaveSettings;

use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;

class SaveSettingsHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(protected SettingsRepository $repo)
    {
    }

    // ———————————————————————————————————————————————————————————————
    // Handle
    // ———————————————————————————————————————————————————————————————

    public function go(SaveSettings $command): bool
    {
        $settings = $this->repo->findByCode($command->getCode());
        if (is_null($settings)) {
            $settings = Settings::make(
                $this->repo->nextIdentity(),
                $command->getCode(),
                $command->getYearlyFee2Training(),
                $command->getYearlyFee1Training(),
                $command->getHalfYearlyFee2Training(),
                $command->getHalfYearlyFee1Training(),
                $command->getExtraTrainingFee(),
                $command->getNewMemberSubscriptionFee(),
                $command->getFamilyDiscount(),
            );
        } else {
            $settings->change(
                $command->getYearlyFee2Training(),
                $command->getYearlyFee1Training(),
                $command->getHalfYearlyFee2Training(),
                $command->getHalfYearlyFee1Training(),
                $command->getExtraTrainingFee(),
                $command->getNewMemberSubscriptionFee(),
                $command->getFamilyDiscount(),
            );
        }
        $this->repo->save($settings);

        return true;
    }
}
