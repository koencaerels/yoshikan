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

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait ConfigurationRoutes
{
    #[Route('/mm/api/member/configuration', methods: ['GET'])]
    public function getConfiguration(Request $request): JsonResponse
    {
        $response = $this->queryBus->getConfiguration();

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/configuration/setup', methods: ['GET'])]
    public function setupConfiguration(Request $request): JsonResponse
    {
        $response = $this->commandBus->setupConfiguration();

        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
