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

trait get_member
{
    public function searchMembers(\stdClass $jsonSearchModel): MemberReadModelCollection
    {
        $searchModel = MemberSearchModel::hydrateFromJson($jsonSearchModel);
        $query = new GetMember($this->memberRepository, $this->locationRepository, $this->gradeRepository);
        return $query->search($searchModel);
    }

    public function getMemberById(int $id): MemberReadModel
    {
        $query = new GetMember($this->memberRepository, $this->locationRepository, $this->gradeRepository);
        return $query->getById($id);
    }
}
