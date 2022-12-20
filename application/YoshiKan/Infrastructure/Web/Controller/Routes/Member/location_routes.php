<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait location_routes
{
    #[Route('/mm/api/location/add', methods: ['POST', 'PUT'])]
    public function addLocation(Request $request)
    {
        $jsonCommand = json_decode($request->request->get('location'));
        $response = $this->commandBus->addLocation($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/location/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeLocation(int $id, Request $request)
    {
        $jsonCommand = json_decode($request->request->get('location'));
        $response = $this->commandBus->changeLocation($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
