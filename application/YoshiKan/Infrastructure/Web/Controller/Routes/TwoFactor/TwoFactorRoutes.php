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

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\TwoFactor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait TwoFactorRoutes
{
    #[Route('/mm/api/member/request-access', methods: ['GET'])]
    public function requestAccessToTheMemberModule(Request $request): JsonResponse
    {
        $user = $this->security->getUser();
        if (true === is_null($user)) {
            return new JsonResponse(false, 200, $this->apiAccess);
        }
        $result = $this->commandBus->generateAndSendMemberAccessCode($user->getId());

        return new JsonResponse($result, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/validate-access/{verificationCode}', requirements: ['verificationCode' => '\d+'], methods: ['GET'])]
    public function validateAccessToTheMemberModule(Request $request, int $verificationCode): JsonResponse
    {
        $user = $this->security->getUser();
        if (true === is_null($user)) {
            return new JsonResponse(false, 200, $this->apiAccess);
        }
        $result = $this->commandBus->validateMemberAccessCode($verificationCode, $user->getId());

        return new JsonResponse($result, 200, $this->apiAccess);
    }
}
