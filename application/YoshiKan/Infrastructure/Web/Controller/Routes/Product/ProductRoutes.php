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

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Product;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

trait ProductRoutes
{
    // ——————————————————————————————————————————————————————————————————————————
    // Get the complete product tree
    // ——————————————————————————————————————————————————————————————————————————

    #[Route('/mm/api/products', methods: ['GET'])]
    public function getProductTree(): JsonResponse
    {
        return new JsonResponse($this->queryBus->getProductTree()->getCollection(), 200, $this->apiAccess);
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Products
    // ——————————————————————————————————————————————————————————————————————————

    #[Route('/mm/api/product/add', methods: ['POST', 'PUT'])]
    public function addProduct(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('command'));
        $response = $this->commandBus->addProduct($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/product/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeProduct(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('command'));
        $response = $this->commandBus->changeProduct($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/product/order', methods: ['POST', 'PUT'])]
    public function orderProduct(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('sequence'));
        $response = $this->commandBus->orderProduct($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Product group
    // ——————————————————————————————————————————————————————————————————————————

    #[Route('/mm/api/product/group/add', methods: ['POST', 'PUT'])]
    public function addProductGroup(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('command'));
        $response = $this->commandBus->addProductGroup($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/product/group/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeProductGroup(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('command'));
        $response = $this->commandBus->changeProductGroup($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/product/group/order', methods: ['POST', 'PUT'])]
    public function orderProductGroup(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('sequence'));
        $response = $this->commandBus->orderProductGroup($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Product item
    // ——————————————————————————————————————————————————————————————————————————

    #[Route('/mm/api/product/item/add', methods: ['POST', 'PUT'])]
    public function addProductItem(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('command'));
        $response = $this->commandBus->addProductItem($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/product/item/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeProductItem(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('command'));
        $response = $this->commandBus->changeProductItem($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/product/item/order', methods: ['POST', 'PUT'])]
    public function orderProductItem(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('sequence'));
        $response = $this->commandBus->orderProductItem($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Product item batch
    // ——————————————————————————————————————————————————————————————————————————

    #[Route('/mm/api/product/item/batch/add', methods: ['POST', 'PUT'])]
    public function addProductItemBatch(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('command'));
        $response = $this->commandBus->addProductItemBatch($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/product/item/batch/{id}', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeProductItemBatch(int $id, Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('command'));
        $response = $this->commandBus->changeProductItemBatch($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/product/item/batch/order', methods: ['POST', 'PUT'])]
    public function orderProductItemBatch(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('sequence'));
        $response = $this->commandBus->orderProductItemBatch($jsonCommand);

        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
