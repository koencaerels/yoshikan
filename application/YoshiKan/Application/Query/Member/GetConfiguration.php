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

use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\GroupRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SettingsCode;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;

class GetConfiguration
{
    public function __construct(
        protected GradeRepository $gradeRepository,
        protected LocationRepository $locationRepository,
        protected GroupRepository $groupRepository,
        protected PeriodRepository $periodRepository,
        protected SettingsRepository $settingsRepository
    ) {
    }

    public function getFullConfiguration(): ConfigurationReadModel
    {
        $grades = $this->gradeRepository->getAll();
        $locations = $this->locationRepository->getAll();
        $groups = $this->groupRepository->getAll();
        $periods = $this->periodRepository->getAll();
        $activePeriod = $this->periodRepository->getActive();
        $settings = $this->settingsRepository->findByCode(SettingsCode::ACTIVE->value);

        $gradeCollection = new GradeReadModelCollection();
        foreach ($grades as $grade) {
            $gradeCollection->addItem(GradeReadModel::hydrateFromModel($grade));
        }
        $locationCollection = new LocationReadModelCollection();
        foreach ($locations as $location) {
            $locationCollection->addItem(LocationReadModel::hydrateFromModel($location));
        }
        $groupCollection = new GroupReadModelCollection();
        foreach ($groups as $group) {
            $groupCollection->addItem(GroupReadModel::hydrateFromModel($group));
        }
        $periodCollection = new PeriodReadModelCollection();
        foreach ($periods as $period) {
            $periodCollection->addItem(PeriodReadModel::hydrateFromModel($period));
        }
        $activePeriodReadModel = PeriodReadModel::hydrateFromModel($activePeriod);
        $settingsReadModel = SettingsReadModel::hydrateFromModel($settings);

        return new ConfigurationReadModel(
            $gradeCollection,
            $locationCollection,
            $groupCollection,
            $periodCollection,
            $activePeriodReadModel,
            $settingsReadModel
        );
    }

    public function getWebConfiguration(): WebConfigurationReadModel
    {
        $grades = $this->gradeRepository->getAll();
        $locations = $this->locationRepository->getAll();
        $groups = $this->groupRepository->getAll();
        $activePeriod = $this->periodRepository->getActive();
        $settings = $this->settingsRepository->findByCode(SettingsCode::ACTIVE->value);

        $gradeCollection = new GradeReadModelCollection();
        foreach ($grades as $grade) {
            $gradeCollection->addItem(GradeReadModel::hydrateFromModel($grade));
        }
        $locationCollection = new LocationReadModelCollection();
        foreach ($locations as $location) {
            $locationCollection->addItem(LocationReadModel::hydrateFromModel($location));
        }
        $groupCollection = new GroupReadModelCollection();
        foreach ($groups as $group) {
            $groupCollection->addItem(GroupReadModel::hydrateFromModel($group));
        }
        $activePeriodReadModel = PeriodReadModel::hydrateFromModel($activePeriod);
        $settingsReadModel = SettingsReadModel::hydrateFromModel($settings);

        return new WebConfigurationReadModel(
            $gradeCollection,
            $locationCollection,
            $groupCollection,
            $activePeriodReadModel,
            $settingsReadModel
        );
    }
}
