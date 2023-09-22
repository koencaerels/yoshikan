<?php

namespace App\YoshiKan\Application\Query\Member;

use App\YoshiKan\Application\Query\Member\Readmodel\MemberImageReadModel;
use App\YoshiKan\Domain\Model\Member\MemberImageRepository;

class GetMemberImage
{
    public function __construct(protected MemberImageRepository $memberImageRepository)
    {
    }

    public function getById(int $id): MemberImageReadModel
    {
        return MemberImageReadModel::hydrateFromModel($this->memberImageRepository->getById($id));
    }
}
