<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait grade_routes
{
    #[Route('/api/grade/add', methods: ['POST', 'PUT'])]
    public function addGrade(Request $request)
    {
        $jsonCommand = json_decode($request->request->get('grade'));
        $response = $this->commandBus->addGrade($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/api/grade/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeGrade(int $id, Request $request)
    {
        $jsonCommand = json_decode($request->request->get('grade'));
        $response = $this->commandBus->changeGrade($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
