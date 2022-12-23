<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
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

}
