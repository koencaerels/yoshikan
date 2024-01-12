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

namespace App\YoshiKan\Application\Command\TwoFactor\ValidateMemberAccessCode;

use App\YoshiKan\Infrastructure\Database\TwoFactor\MemberAccessCodeRepository;
use Bolt\Repository\UserRepository;

class ValidateMemberAccessCodeHandler
{
    public function __construct(
        protected UserRepository $userRepository,
        protected MemberAccessCodeRepository $memberAccessCodeRepository,
    ) {
    }

    public function validate(ValidateMemberAccessCode $command): bool
    {
        $result = false;
        $user = $this->userRepository->findOneBy(['id' => $command->getUserId()]);
        if (true === is_null($user)) {
            return false;
        }

        $hashedCode = hash('SHA256', (string) $command->getAccessCode().'*'.$_SERVER['APP_SECRET']);
        $memberAccessCode = $this->memberAccessCodeRepository->findByCode($hashedCode);
        if (true === is_null($memberAccessCode)) {
            return false;
        }
        if ($memberAccessCode->getUser()->getId() !== $user->getId()) {
            return false;
        }
        if (false === $memberAccessCode->isActive()) {
            return false;
        }

        // -- use the code
        $memberAccessCode->use();
        $this->memberAccessCodeRepository->save($memberAccessCode);

        // -- invalidate all other codes for that user
        $memberAccessCodes = $this->memberAccessCodeRepository->getByUser($user);
        foreach ($memberAccessCodes as $memberAccessCodeEntity) {
            $memberAccessCodeEntity->invalidate();
            $this->memberAccessCodeRepository->save($memberAccessCodeEntity);
        }

        return true;
    }
}
