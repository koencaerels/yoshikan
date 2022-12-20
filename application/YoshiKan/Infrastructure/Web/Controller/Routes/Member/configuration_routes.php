<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;

trait configuration_routes
{
    #[Route('/mm/api/configuration', methods: ['GET'])]
    public function getConfiguration(Request $request)
    {
        $response = $this->queryBus->getConfiguration();
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
