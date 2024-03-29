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

trait SettingsRoutes
{
    #[Route('/mm/api/member/settings', methods: ['POST', 'PUT'])]
    public function saveSettings(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('settings'));
        $response = $this->commandBus->saveSettings($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
