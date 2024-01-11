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

namespace App\YoshiKan\Application\Query\Member;

use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;

class DownloadDuePayments
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
    ) {
    }

    public function downloadDuePayments(): void
    {
        $locations = $this->locationRepository->getAll();
        $renderList = new \stdClass();
        $renderList->generatedOn = new \DateTimeImmutable();
        $renderList->federations = $this->federationRepository->getAll();
        $renderList->locations = [];
        foreach ($locations as $location) {
            $locationResult = new \stdClass();
            $locationResult->location = $location;
            $locationResult->subscriptions = $this->subscriptionRepository->getByDuePaymentByLocation($location);
            $renderList->locations[] = $locationResult;
        }

        $pdfHtml = $this->twig->render('pdf/due_payments.html.twig', ['list' => $renderList]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdfHtml);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $fileName = $renderList->generatedOn->format('YmdHis').'_yoshikan_due_payments.pdf';

        $dompdf->stream($fileName, ['Attachment' => false]);

        exit;
    }
}
