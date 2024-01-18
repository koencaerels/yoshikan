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
use App\YoshiKan\Domain\Model\Member\SettingsCode;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
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
        protected SettingsRepository $settingsRepository,
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

        $fileName = $renderList->generatedOn->format('YmdHis').'_yoshikan_inschrijvingen.pdf';

        /** @var Subscription $subscription */
        foreach ($subscriptions as $subscription) {
            $subscription->flagSubscriptionIsPrinted();
            $this->subscriptionRepository->save($subscription);
        }
        $this->entityManager->flush();

        $dompdf->stream($fileName, ['Attachment' => false]);

        exit;
    }

    public function printEmptySubscriptionForm(): void
    {
        $settings = $this->settingsRepository->findByCode(SettingsCode::ACTIVE->value);
        $federations = $this->federationRepository->getAll();
        $locations = $this->locationRepository->getAll();

        $data = new \stdClass();
        $data->generatedOn = new \DateTimeImmutable();
        $data->settings = $settings;
        $data->federations = $federations;
        $data->locations = $locations;

        $pdfHtml = $this->twig->render('pdf/empty_subscription_form.html.twig', ['data' => $data]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdfHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = $data->generatedOn->format('YmdHis').'_yoshikan_inschrijving_formulier.pdf';
        $dompdf->stream($fileName, ['Attachment' => false]);

        exit;
    }
}
