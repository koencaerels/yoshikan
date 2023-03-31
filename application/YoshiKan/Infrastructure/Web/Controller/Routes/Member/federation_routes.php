<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\Request;

trait federation_routes
{

    // —————————————————————————————————————————————————————————————————————————————
    // —— Federations (input)
    // —————————————————————————————————————————————————————————————————————————————

    #[Route('/mm/api/member/federation/order', methods: ['POST', 'PUT'])]
    public function orderGrade(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('sequence'));
        $response = $this->commandBus->orderFederation($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/federation/add', methods: ['POST', 'PUT'])]
    public function addFederation(Request $request)
    {
        $jsonCommand = json_decode($request->request->get('federation'));
        $response = $this->commandBus->addFederation($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/federation/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeFederation(int $id, Request $request)
    {
        $jsonCommand = json_decode($request->request->get('federation'));
        $response = $this->commandBus->changeFederation($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
