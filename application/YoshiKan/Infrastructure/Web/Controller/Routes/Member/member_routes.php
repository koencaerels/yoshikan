<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait member_routes
{
    #[Route('/mm/api/member/search', methods: ['GET', 'POST', 'PUT'])]
    public function searchMembers(Request $request): JsonResponse
    {
        $searchModel = json_decode($request->request->get('search-model'));
        $response = $this->queryBus->searchMembers($searchModel);
        return new JsonResponse($response->getCollection(), 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getMemberById(int $id): JsonResponse
    {
        $response = $this->queryBus->getMemberById($id);
        usleep(500000);
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
