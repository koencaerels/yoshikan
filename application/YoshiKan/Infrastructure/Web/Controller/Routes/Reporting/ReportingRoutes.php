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

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Reporting;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait ReportingRoutes
{
    /**
     * @throws \Exception
     */
    #[Route('/mm/api/get-dashboard-numbers', methods: ['GET'])]
    public function getDashboardNumbers(Request $request): JsonResponse
    {
        return new JsonResponse($this->queryBus->getDashboardNumbers(), 200, $this->apiAccess);
    }
}
