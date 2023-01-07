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

trait judogi_routes
{
    #[Route('/mm/api/member/judogi/order', methods: ['POST', 'PUT'])]
    public function orderJudogi(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('sequence'));
        $response = $this->commandBus->orderJudogi($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/judogi/add', methods: ['POST', 'PUT'])]
    public function addJudogi(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('judogi'));
        $response = $this->commandBus->addJudogi($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/judogi/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeJudogi(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('judogi'));
        $response = $this->commandBus->changeJudogi($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
