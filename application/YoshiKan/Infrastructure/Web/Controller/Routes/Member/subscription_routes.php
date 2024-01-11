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

use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait subscription_routes
{
    #[Route('/mm/api/subscription/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getSubscriptionById(int $id): JsonResponse
    {
        $response = $this->queryBus->getSubscriptionById($id);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    /**
     * @throws \Exception
     */
    #[Route('/mm/api/subscription/{id}/mark-as-paid', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function markSubscriptionAsPayed(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('command'));
        $response = $this->commandBus->markSubscriptionAsPayed($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    /**
     * @throws \Exception
     */
    #[Route('/mm/api/subscription/{id}/cancel', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function markSubscriptionAsCanceled(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('command'));
        $response = $this->commandBus->markSubscriptionAsCanceled($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/subscription/{status}', methods: ['GET'])]
    public function getAllSubscriptions(string $status, Request $request): JsonResponse
    {
        $response = $this->queryBus->getSubscriptionsByStatus($status);

        return new JsonResponse($response->getCollection(), 200, $this->apiAccess);
    }

    /**
     * @throws Exception
     */
    #[Route('/mm/api/subscriptions/export', methods: ['GET'])]
    public function exportSubscriptions(Request $request): void
    {
        $listIds = $request->query->get('ids');
        $spreadsheet = $this->queryBus->exportSubscriptions($this->convertToArrayOfIds($listIds));
        $now = new \DateTimeImmutable();
        $fileName = $now->format('Ymd') . '_yoshi-kan-inschrijvingen.xlsx';
        $writer = new Xlsx($spreadsheet);

        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');
        exit;
    }

    #[Route('/mm/api/subscriptions/print', methods: ['GET'])]
    public function printSubscriptions(Request $request): void
    {
        $listIds = $request->query->get('ids');
        $document = $this->queryBus->printSubscriptions($this->convertToArrayOfIds($listIds));

        exit;
    }

    private function convertToArrayOfIds(string $ids): array
    {
        $arListIdsInt = [];
        foreach (explode(',', $ids) as $id) {
            $arListIdsInt[] = intval($id);
        }

        return $arListIdsInt;
    }

    //    #[Route('/mm/api/subscribe', name: 'backend_subscribe', methods: ['POST', 'PUT'])]
    //    public function backendSubscribeAction(Request $request): JsonResponse
    //    {
    //        $jsonCommand = json_decode($request->request->get('subscription'));
    //        $response = $this->commandBus->WebSubscriptionAction($jsonCommand);
    //
    //        return new JsonResponse($response, 200, $this->apiAccess);
    //    }
    //
    //    #[Route('/mm/api/subscription/todo', name: 'get_todo_subscriptions', methods: ['GET'])]
    //    public function getTodoSubscriptions(): JsonResponse
    //    {
    //        // $response = $this->queryBus->getTodoSubscription();
    //        // todo replace this with correct list
    //        $response = [];
    //
    //        return new JsonResponse($response, 200, $this->apiAccess);
    //    }
    //
    //    #[Route('/mm/api/subscription/active-period', methods: ['GET'])]
    //    public function getSubscriptionsByActivePeriod(): JsonResponse
    //    {
    //        $response = $this->queryBus->getSubscriptionsByActivePeriod();
    //
    //        return new JsonResponse($response, 200, $this->apiAccess);
    //    }
    //
    //    #[Route('/mm/api/subscription/all', methods: ['GET'])]
    //    public function getAllSubscriptions(): JsonResponse
    //    {
    //        $response = $this->queryBus->getAllSubscriptions();
    //
    //        return new JsonResponse($response, 200, $this->apiAccess);
    //    }
    //
    //    #[Route('/mm/api/subscription/mark-as-finished', methods: ['POST', 'PUT'])]
    //    public function markSubscriptionsAsFinished(Request $request): JsonResponse
    //    {
    //        $jsonCommand = json_decode($request->request->get('list-ids'));
    //        $response = $this->commandBus->markSubscriptionAsFinished($jsonCommand);
    //
    //        return new JsonResponse($response, 200, $this->apiAccess);
    //    }
    //
    //    #[Route('/mm/api/subscription/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    //    public function changeSubscription(int $id, Request $request): JsonResponse
    //    {
    //        $jsonCommand = json_decode($request->request->get('subscription'));
    //        $response = $this->commandBus->changeSubscription($jsonCommand);
    //
    //        return new JsonResponse($response, 200, $this->apiAccess);
    //    }
    //
    //    #[Route('/mm/api/subscription/{id}/change-status', methods: ['POST', 'PUT'])]
    //    public function changeSubscriptionStatus(int $id, Request $request): JsonResponse
    //    {
    //        $jsonCommand = json_decode($request->request->get('change-status'));
    //        $response = $this->commandBus->changeSubscriptionStatus($jsonCommand);
    //
    //        return new JsonResponse($response, 200, $this->apiAccess);
    //    }
    //
    //    #[Route('/mm/api/subscription/{id}/mail-payment-information', methods: ['POST', 'PUT'])]
    //    public function sendPaymentOverviewMail(int $id, Request $request): JsonResponse
    //    {
    //        $response = $this->commandBus->sendPaymentOverviewMail($id);
    //
    //        return new JsonResponse($response, 200, $this->apiAccess);
    //    }
    //
    //    #[Route('/mm/api/subscription/{id}/connect-member', methods: ['POST', 'PUT'])]
    //    public function connectMemberToSubscription(int $id, Request $request): JsonResponse
    //    {
    //        $jsonCommand = json_decode($request->request->get('connect-member'));
    //        $response = $this->commandBus->connectSubscriptionToMember($jsonCommand);
    //
    //        return new JsonResponse($response, 200, $this->apiAccess);
    //    }
    //
    //    #[Route('/mm/api/subscription/{id}/create-member', methods: ['POST', 'PUT'])]
    //    public function createMemberFromSubscription(int $id, Request $request): JsonResponse
    //    {
    //        $response = $this->commandBus->createMemberFromSubscription($id);
    //
    //        return new JsonResponse($response, 200, $this->apiAccess);
    //    }
}
