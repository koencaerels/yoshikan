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

use App\YoshiKan\Application\Query\Member\Readmodel\ConfigurationReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\WebConfigurationReadModel;

trait get_configuration
{
    public function getWebConfiguration(): WebConfigurationReadModel
    {
        $query = new GetConfiguration(
            $this->gradeRepository,
            $this->locationRepository,
            $this->groupRepository,
            $this->periodRepository,
            $this->settingsRepository,
            $this->federationRepository,
            $this->judogiRepository
        );

        return $query->getWebConfiguration();
    }

    public function getConfiguration(): ConfigurationReadModel
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $query = new GetConfiguration(
            $this->gradeRepository,
            $this->locationRepository,
            $this->groupRepository,
            $this->periodRepository,
            $this->settingsRepository,
            $this->federationRepository,
            $this->judogiRepository
        );

        return $query->getFullConfiguration();
    }
}
