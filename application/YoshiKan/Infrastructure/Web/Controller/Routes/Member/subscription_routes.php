<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait subscription_routes
{
    #[Route('/mm/api/subscribe', name: 'backend_subscribe', methods: ['POST', 'PUT'])]
    public function backendSubscribeAction(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('subscription'));
        $response = $this->commandBus->WebSubscriptionAction($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/subscription/todo', name: 'get_todo_subscriptions', methods: ['GET'])]
    public function getTodoSubscriptions(): JsonResponse
    {
        $response = $this->queryBus->getTodoSubscription();
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/subscription/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getSubscriptionById(int $id): JsonResponse
    {
        $response = $this->queryBus->getSubscriptionById($id);
        usleep(500000);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/subscription/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeSubscription(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('subscription'));
        $response = $this->commandBus->changeSubscription($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/subscription/{id}/change-status', methods: ['POST', 'PUT'])]
    public function changeSubscriptionStatus(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('change-status'));
        $response = $this->commandBus->changeSubscriptionStatus($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/subscription/{id}/mail-payment-information', methods: ['POST', 'PUT'])]
    public function sendPaymentOverviewMail(int $id, Request $request): JsonResponse
    {
        $response = $this->commandBus->sendPaymentOverviewMail($id);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/subscription/{id}/connect-member', methods: ['POST', 'PUT'])]
    public function connectMemberToSubscription(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('connect-member'));
        $response = $this->commandBus->connectSubscriptionToMember($jsonCommand);
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/subscription/{id}/create-member', methods: ['POST', 'PUT'])]
    public function createMemberFromSubscription(int $id, Request $request): JsonResponse
    {
        $response = $this->commandBus->createMemberFromSubscription($id);
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
