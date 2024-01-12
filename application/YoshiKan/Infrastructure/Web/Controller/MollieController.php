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

namespace App\YoshiKan\Infrastructure\Web\Controller;

use App\YoshiKan\Domain\Model\Member\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;

class MollieController extends AbstractController
{
    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected KernelInterface $appKernel,
        protected Environment $twig,
    ) {
        $this->setTwigLoader($this->appKernel);
    }

    private function setTwigLoader(KernelInterface $appKernel): void
    {
        /** @var FilesystemLoader|ChainLoader $twigLoaders */
        $twigLoaders = $this->twig->getLoader();
        $twigLoaders = $twigLoaders instanceof ChainLoader ?
            $twigLoaders->getLoaders() :
            [$twigLoaders];
        $path = $appKernel->getProjectDir().'/public/theme/YoshiKan2023/';
        foreach ($twigLoaders as $twigLoader) {
            if ($twigLoader instanceof FilesystemLoader) {
                $twigLoader->prependPath($path, '__main__');
            }
        }
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Payment confirmation feedback
    // ——————————————————————————————————————————————————————————————————————————

    #[Route('/mm/lidgeld/betaling/{paymentId}/ok', name: 'mollie_payment_confirmation_feedback', methods: ['GET', 'POST', 'PUT'])]
    public function molliePaymentConfirmationFeedback(Request $request, string $paymentId): Response
    {
        $subscription = $this->entityManager->getRepository(Subscription::class)->findByPaymentId($paymentId);
        if (false === is_null($subscription)) {
            return $this->render('paid.twig', [
                'subscription' => $subscription,
            ]);
        } else {
            return new JsonResponse('No subscription linked to this ID.', 200, []);
        }
    }
}
