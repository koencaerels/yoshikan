<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait group_routes
{
    #[Route('/mm/api/group/add', methods: ['POST', 'PUT'])]
    public function addGroup(Request $request)
    {
        $jsonCommand = json_decode($request->request->get('group'));
        $response = $this->commandBus->addGroup($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/group/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeGroup(int $id, Request $request)
    {
        $jsonCommand = json_decode($request->request->get('group'));
        $response = $this->commandBus->changeGroup($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
