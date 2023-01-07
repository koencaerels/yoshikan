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

trait group_routes
{
    #[Route('/mm/api/member/group/order', methods: ['POST', 'PUT'])]
    public function orderGroup(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('sequence'));
        $response = $this->commandBus->orderGroup($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/group/add', methods: ['POST', 'PUT'])]
    public function addGroup(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('group'));
        $response = $this->commandBus->addGroup($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/group/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeGroup(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('group'));
        $response = $this->commandBus->changeGroup($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
