<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait grade_routes
{

    #[Route('/mm/api/member/grade/order', methods: ['POST', 'PUT'])]
    public function orderGrade(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('sequence'));
        $response = $this->commandBus->orderGrade($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/grade/add', methods: ['POST', 'PUT'])]
    public function addGrade(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('grade'));
        $response = $this->commandBus->addGrade($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/grade/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeGrade(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('grade'));
        $response = $this->commandBus->changeGrade($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
