<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait location_routes
{
    #[Route('/mm/api/member/location/order', methods: ['POST', 'PUT'])]
    public function orderLocation(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('sequence'));
        $response = $this->commandBus->orderLocation($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/location/add', methods: ['POST', 'PUT'])]
    public function addLocation(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('location'));
        $response = $this->commandBus->addLocation($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/location/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeLocation(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('location'));
        $response = $this->commandBus->changeLocation($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
