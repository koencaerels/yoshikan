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

trait get_member
{
    public function listActiveMembers(): MemberReadModelCollection
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);
        $query = new GetMember(
            $this->memberRepository,
            $this->locationRepository,
            $this->gradeRepository,
            $this->groupRepository,
            $this->periodRepository
        );

        return $query->listActiveMembers();
    }

    public function searchMembers(\stdClass $jsonSearchModel): MemberReadModelCollection
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);
        $searchModel = MemberSearchModel::hydrateFromJson($jsonSearchModel);
        $query = new GetMember(
            $this->memberRepository,
            $this->locationRepository,
            $this->gradeRepository,
            $this->groupRepository,
            $this->periodRepository
        );

        return $query->search($searchModel);
    }

    public function suggestMember(\stdClass $jsonSuggestModel): MemberReadModelCollection
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);
        $suggestModel = MemberSuggestModel::hydrateFromJson($jsonSuggestModel);
        $query = new GetMember(
            $this->memberRepository,
            $this->locationRepository,
            $this->gradeRepository,
            $this->groupRepository,
            $this->periodRepository
        );

        return $query->suggest($suggestModel);
    }

    public function getMemberById(int $id): MemberReadModel
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);
        $query = new GetMember(
            $this->memberRepository,
            $this->locationRepository,
            $this->gradeRepository,
            $this->groupRepository,
            $this->periodRepository
        );

        return $query->getById($id);
    }
}
