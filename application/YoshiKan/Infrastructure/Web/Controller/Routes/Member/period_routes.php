<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait period_routes
{
    #[Route('/mm/api/period/add', methods: ['POST', 'PUT'])]
    public function addPeriod(Request $request)
    {
        $jsonCommand = json_decode($request->request->get('period'));
        $response = $this->commandBus->addPeriod($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/period/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changePeriod(int $id, Request $request)
    {
        $jsonCommand = json_decode($request->request->get('period'));
        $response = $this->commandBus->changePeriod($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
