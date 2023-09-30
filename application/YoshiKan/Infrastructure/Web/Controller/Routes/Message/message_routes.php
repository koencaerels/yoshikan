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

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Message;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait message_routes
{
    /**
     * @throws \Exception
     */
    #[Route('/mm/api/message/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getMessageById(int $id, Request $request): JsonResponse
    {
        $response = $this->queryBus->getMessageById($id);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/message/{id}/resend', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function resendMessage(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('command'));
        $response = $this->commandBus->resendMessage($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
