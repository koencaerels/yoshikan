<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait period_routes
{
    #[Route('/mm/api/member/period/order', methods: ['POST', 'PUT'])]
    public function orderPeriod(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('sequence'));
        $response = $this->commandBus->orderPeriod($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/period/add', methods: ['POST', 'PUT'])]
    public function addPeriod(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('period'));
        $response = $this->commandBus->addPeriod($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/period/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changePeriod(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('period'));
        $response = $this->commandBus->changePeriod($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
