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
use App\YoshiKan\Application\Query\Member\Readmodel\FederationReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\FederationReadModelCollection;
use App\YoshiKan\Application\Query\Member\Readmodel\GradeReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\GradeReadModelCollection;
use App\YoshiKan\Application\Query\Member\Readmodel\GroupReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\GroupReadModelCollection;
use App\YoshiKan\Application\Query\Member\Readmodel\LocationReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\LocationReadModelCollection;
use App\YoshiKan\Application\Query\Member\Readmodel\PeriodReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\PeriodReadModelCollection;
use App\YoshiKan\Application\Query\Member\Readmodel\SettingsReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\WebConfigurationReadModel;
use App\YoshiKan\Application\Query\Product\Readmodel\JudogiReadModel;
use App\YoshiKan\Application\Query\Product\Readmodel\JudogiReadModelCollection;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\GroupRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SettingsCode;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Product\JudogiRepository;

class GetConfiguration
{
    public function __construct(
        protected GradeRepository $gradeRepository,
        protected LocationRepository $locationRepository,
        protected GroupRepository $groupRepository,
        protected PeriodRepository $periodRepository,
        protected SettingsRepository $settingsRepository,
        protected FederationRepository $federationRepository,
        protected JudogiRepository $judogiRepository
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
        $federations = $this->federationRepository->getAll();
        $judugis = $this->judogiRepository->getAll();

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

        $federationCollection = new FederationReadModelCollection();
        foreach ($federations as $federation) {
            $federationCollection->addItem(FederationReadModel::hydrateFromModel($federation));
        }
        $judogiCollection = new JudogiReadModelCollection();
        foreach ($judugis as $judogi) {
            $judogiCollection->addItem(JudogiReadModel::hydrateFromModel($judogi));
        }

        return new ConfigurationReadModel(
            $gradeCollection,
            $locationCollection,
            $groupCollection,
            $periodCollection,
            $federationCollection,
            $judogiCollection,
            $activePeriodReadModel,
            $settingsReadModel
        );
    }

    public function getWebConfiguration(): WebConfigurationReadModel
    {
        $locations = $this->locationRepository->getAll();
        $activePeriod = $this->periodRepository->getActive();
        $settings = $this->settingsRepository->findByCode(SettingsCode::ACTIVE->value);
        $federations = $this->federationRepository->getAll();

        $locationCollection = new LocationReadModelCollection();
        foreach ($locations as $location) {
            $locationCollection->addItem(LocationReadModel::hydrateFromModel($location));
        }

        $federationCollection = new FederationReadModelCollection();
        foreach ($federations as $federation) {
            $federationCollection->addItem(FederationReadModel::hydrateFromModel($federation));
        }

        $activePeriodReadModel = PeriodReadModel::hydrateFromModel($activePeriod);
        $settingsReadModel = SettingsReadModel::hydrateFromModel($settings);

        return new WebConfigurationReadModel(
            $locationCollection,
            $activePeriodReadModel,
            $settingsReadModel,
            $federationCollection
        );
    }
}
