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

use App\YoshiKan\Application\Query\Member\Readmodel\MemberReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\MemberReadModelCollection;
use App\YoshiKan\Application\Query\Member\Readmodel\MemberSearchModel;
use App\YoshiKan\Application\Query\Member\Readmodel\MemberSuggestModel;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\GroupRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;

class GetMember
{
    public function __construct(
        protected MemberRepository $memberRepository,
        protected LocationRepository $locationRepository,
        protected GradeRepository $gradeRepository,
        protected GroupRepository $groupRepository,
        protected PeriodRepository $periodRepository
    ) {
    }

    public function search(MemberSearchModel $searchModel): MemberReadModelCollection
    {
        $location = null;
        if (0 != $searchModel->getLocationId()) {
            $location = $this->locationRepository->getById($searchModel->getLocationId());
        }
        $grade = null;
        if (0 != $searchModel->getGradeId()) {
            $grade = $this->gradeRepository->getById($searchModel->getGradeId());
        }

        // -- filter on the group -------------------------------------------------------
        $minYearOfBirth = 0;
        $maxYearOfBirth = 0;
        if (0 != $searchModel->getGroupId()) {
            $group = $this->groupRepository->getById($searchModel->getGroupId());
            $activePeriod = $this->periodRepository->getActive();
            $startYear = intval($activePeriod->getStartDate()->format('Y'));
            $minYearOfBirth = $startYear - $group->getMaxAge();
            $maxYearOfBirth = $startYear - $group->getMinAge();
        }

        // -- search -------------------------------------------------------------------
        $members = $this->memberRepository->search(
            $searchModel->getKeyword(),
            $searchModel->getYearOfBirth(),
            $location,
            $grade,
            $minYearOfBirth,
            $maxYearOfBirth
        );

        // -- covert to readmodel collection ------------------------------------------
        $collection = new MemberReadModelCollection([]);
        foreach ($members as $member) {
            $collection->addItem(MemberReadModel::hydrateFromModel($member));
        }

        return $collection;
    }

    public function suggest(MemberSuggestModel $suggestModel): MemberReadModelCollection
    {
        $members = $this->memberRepository->findByNameOrDateOfBirth(
            $suggestModel->getFirstname(),
            $suggestModel->getLastname(),
            $suggestModel->getDateOfBirth()
        );
        $collection = new MemberReadModelCollection([]);
        foreach ($members as $member) {
            $collection->addItem(MemberReadModel::hydrateFromModel($member));
        }

        return $collection;
    }

    public function listActiveMembers(): MemberReadModelCollection
    {
        $members = $this->memberRepository->listActiveMembers();
        $collection = new MemberReadModelCollection([]);
        foreach ($members as $member) {
            $collection->addItem(MemberReadModel::hydrateFromModel($member));
        }

        return $collection;
    }

    public function getById(int $id): MemberReadModel
    {
        $member = $this->memberRepository->getById($id);

        return MemberReadModel::hydrateFromModel($member, true);
    }
}
