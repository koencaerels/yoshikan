<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait settings_routes
{
    #[Route('/mm/api/member/settings', methods: ['POST', 'PUT'])]
    public function saveSettings(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('settings'));
        $response = $this->commandBus->saveSettings($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

}
