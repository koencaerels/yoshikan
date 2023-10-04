<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Reporting;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait reporting_routes
{
    /**
     * @throws \Exception
     */
    #[Route('/mm/api/get-dashboard-numbers', methods: ['GET'])]
    public function getDashboardNumbers(Request $request): JsonResponse
    {
        return new JsonResponse($this->queryBus->getDashboardNumbers(), 200, $this->apiAccess);
    }
}
