<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait configuration_routes
{
    #[Route('/mm/api/member/configuration', methods: ['GET'])]
    public function getConfiguration(Request $request)
    {
        $response = $this->queryBus->getConfiguration();
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/configuration/setup', methods: ['GET'])]
    public function setupConfiguration(Request $request)
    {
        $response = $this->commandBus->setupConfiguration();
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
