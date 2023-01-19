<?php

namespace App\YoshiKan\Application\Command\Member\RemoveMemberImage;

use App\YoshiKan\Domain\Model\Member\MemberImageRepository;

class RemoverMemberImageHandler
{

    public function __construct(
        protected MemberImageRepository $memberImageRepository
    )
    {
    }

    public function go(RemoverMemberImage $command): bool
    {

        return true;
    }

}
