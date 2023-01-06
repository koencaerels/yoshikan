<?php

namespace App\YoshiKan\Application\Command\Member\ChangeMemberDetails;

use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;

class ChangeMemberDetailsHandler
{
    public function __construct(
        protected MemberRepository $memberRepository,
        protected LocationRepository $locationRepository
    )
    {
    }

    public function go(ChangeMemberDetails $command): bool
    {
        $member = $this->memberRepository->getById($command->getId());
        $location = $this->locationRepository->getById($command->getLocationId());

        return true;
    }
}
