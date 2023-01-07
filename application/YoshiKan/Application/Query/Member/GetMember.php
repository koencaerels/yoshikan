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
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;

class GetMember
{
    public function __construct(
        protected MemberRepository   $memberRepository,
        protected LocationRepository $locationRepository,
        protected GradeRepository    $gradeRepository
    )
    {
    }

    public function search(MemberSearchModel $searchModel): MemberReadModelCollection
    {
        $location = null;
        if ($searchModel->getLocationId() != 0) {
            $location = $this->locationRepository->getById($searchModel->getLocationId());
        }
        $grade = null;
        if ($searchModel->getGradeId() != 0) {
            $grade = $this->gradeRepository->getById($searchModel->getGradeId());
        }
        $members = $this->memberRepository->search(
            $searchModel->getKeyword(),
            $searchModel->getYearOfBirth(),
            $location,
            $grade
        );
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

    public function getById(int $id): MemberReadModel
    {
        $member = $this->memberRepository->getById($id);
        return MemberReadModel::hydrateFromModel($member, true);
    }
}
