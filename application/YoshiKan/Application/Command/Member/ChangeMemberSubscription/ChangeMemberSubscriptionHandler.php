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

namespace App\YoshiKan\Application\Command\Member\ChangeMemberSubscription;

use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;

class ChangeMemberSubscriptionHandler
{
    public function __construct(
        protected MemberRepository $memberRepository,
        protected FederationRepository $federationRepository,
    ) {
    }

    public function change(ChangeMemberSubscription $command): bool
    {
        $member = $this->memberRepository->getById($command->getMemberId());
        $federation = $this->federationRepository->getById($command->getFederationId());

        $member->changeSubscription(
            memberShipStart: $command->getMembershipStart(),
            memberShipEnd: $command->getMembershipEnd(),
            isHalfYearSubscription: $command->isMemberShipIsHalfYear(),
            numberOfTraining: $command->getNumberOfTraining(),
            federation: $federation,
            licenseStart: $command->getLicenseStart(),
            licenseEnd: $command->getLicenseEnd(),
        );

        $this->memberRepository->save($member);

        return true;
    }
}
