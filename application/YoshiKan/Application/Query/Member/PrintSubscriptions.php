<?php

namespace App\YoshiKan\Application\Query\Member;

use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;

class PrintSubscriptions
{
    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected LocationRepository $locationRepository,
        protected FederationRepository $federationRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected Environment $twig,
        protected string $uploadFolder,
        protected EntityManagerInterface $entityManager,
    ) {
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Print an overview of the selected subscriptions
    // ——————————————————————————————————————————————————————————————————————————

    public function printOverview(array $listIds): void
    {
        $subscriptions = $this->subscriptionRepository->getByListId($listIds);
        $renderList = new \stdClass();
        $renderList->generatedOn = new \DateTimeImmutable();
        $renderList->subscriptions = $subscriptions;

        $pdfHtml = $this->twig->render('pdf/subscription_detail.html.twig', ['list' => $renderList]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdfHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = $renderList->generatedOn->format('YmdHis') . '_yoshikan_inschrijvingen.pdf';

        /** @var Subscription $subscription */
        foreach ($subscriptions as $subscription) {
            $subscription->flagSubscriptionIsPrinted();
            $this->subscriptionRepository->save($subscription);
        }
        $this->entityManager->flush();

        $dompdf->stream($fileName, ['Attachment' => false]);

        exit;
    }
}
