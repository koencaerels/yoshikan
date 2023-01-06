<?php

namespace App\YoshiKan\Application\Command\Member\ChangeMemberDetails;

use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\MemberStatus;

class ChangeMemberDetailsHandler
{
    public function __construct(
        protected MemberRepository   $memberRepository,
        protected LocationRepository $locationRepository
    ) {
    }

    public function go(ChangeMemberDetails $command): bool
    {
        $member = $this->memberRepository->getById($command->getId());
        $location = $this->locationRepository->getById($command->getLocationId());
        $status = MemberStatus::from($command->getStatus());
        $gender = Gender::from($command->getGender());
        $member->changeDetails(
            $command->getFirstname(),
            $command->getLastname(),
            $gender,
            $command->getDateOfBirth(),
            $status,
            $location
        );
        $this->memberRepository->save($member);

        return true;
    }
}
