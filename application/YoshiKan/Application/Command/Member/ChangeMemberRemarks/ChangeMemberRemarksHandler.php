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

namespace App\YoshiKan\Application\Command\Member\ChangeMemberRemarks;

use App\YoshiKan\Domain\Model\Member\MemberRepository;

class ChangeMemberRemarksHandler
{
    public function __construct(protected MemberRepository $memberRepository)
    {
    }

    public function go(ChangeMemberRemarks $command): bool
    {
        $member = $this->memberRepository->getById($command->getId());
        $member->changeRemarks($command->getRemarks());
        $this->memberRepository->save($member);
        return true;
    }
}
