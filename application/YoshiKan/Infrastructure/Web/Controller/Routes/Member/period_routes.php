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
