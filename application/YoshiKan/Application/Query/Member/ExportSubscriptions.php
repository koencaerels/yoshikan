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

use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Twig\Environment;

class ExportSubscriptions
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected PeriodRepository $periodRepository,
        protected MemberRepository $memberRepository,
        protected LocationRepository $locationRepository,
        protected Environment $twig,
        protected string $uploadFolder,
    ) {
    }

    public function exportSubscriptions(array $listIds): Spreadsheet
    {
        $subscriptions = $this->subscriptionRepository->getByListId($listIds);
        $activePeriod = $this->periodRepository->getActive();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($activePeriod->getName());

        // -- header ----------------------------------------------------------------
        $rowCounter = 1;
        $sheet->setCellValue([1, $rowCounter], 'Ref.');
        $sheet->setCellValue([2, $rowCounter], 'Naam');
        $sheet->setCellValue([3, $rowCounter], 'Voornaam');
        $sheet->setCellValue([4, $rowCounter], 'Geboortedatum');
        $sheet->setCellValue([5, $rowCounter], 'Geslacht');
        $sheet->setCellValue([6, $rowCounter], 'Lidnr.');
        $sheet->setCellValue([7, $rowCounter], 'Graad');
        $sheet->setCellValue([8, $rowCounter], 'Contact');
        $sheet->setCellValue([9, $rowCounter], 'Email');

        // -- data -----------------------------------------------------------------
        ++$rowCounter;
        foreach ($subscriptions as $subscription) {
            $sheet->setCellValue([1, $rowCounter], 'YKS-'.$subscription->getId());
            $sheet->setCellValue([2, $rowCounter], mb_strtoupper($subscription->getLastname()));
            $sheet->setCellValue([3, $rowCounter], $subscription->getFirstname());
            $sheet->setCellValue([4, $rowCounter], $subscription->getDateOfBirth()->format('d/m/Y'));
            $sheet->setCellValue([5, $rowCounter], $subscription->getGenderAsString());
            if (!is_null($subscription->getMember())) {
                $sheet->setCellValue([6, $rowCounter], 'YK-'.$subscription->getMember()->getId());
                $sheet->setCellValue([7, $rowCounter], $subscription->getMember()->getGrade()->getName());
            } else {
                $sheet->setCellValue([6, $rowCounter], 'n/a');
                $sheet->setCellValue([7, $rowCounter], 'n/a');
            }
            $sheet->setCellValue([8, $rowCounter], $subscription->getContactFirstname().' '.$subscription->getContactLastname());
            $sheet->setCellValue([9, $rowCounter], $subscription->getContactEmail());
            ++$rowCounter;
        }

        // -- first row bold ------------------------------------------------------
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle('A1:'.$highestColumn.'1')->getFont()->setBold(true);
        $sheet->setSelectedCell('A1');

        // -- autosize the columns ------------------------------------------------
        for ($i = 'A'; $i != $sheet->getHighestColumn(); ++$i) {
            $sheet->getColumnDimension($i)->setAutoSize(true);
        }
        $sheet->getColumnDimension($sheet->getHighestColumn())->setAutoSize(true);

        return $spreadsheet;
    }

    public function exportMembersForLocation(int $locationId): Spreadsheet
    {
        $location = $this->locationRepository->getById($locationId);
        $locationCode = $location->getCode();
        $members = $this->memberRepository->getActiveMembersByLocation($location);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($location->getName());

        // -- header ----------------------------------------------------------------
        $rowCounter = 1;
        $sheet->setCellValue([1, $rowCounter], 'Ref.');
        $sheet->setCellValue([2, $rowCounter], 'Naam');
        $sheet->setCellValue([3, $rowCounter], 'Voornaam');
        $sheet->setCellValue([4, $rowCounter], 'Geslacht');
        $sheet->setCellValue([5, $rowCounter], 'Geboortedatum');
        $sheet->setCellValue([6, $rowCounter], 'Leeftijd');
        $sheet->setCellValue([7, $rowCounter], 'Adres');
        $sheet->setCellValue([8, $rowCounter], 'Postcode');
        $sheet->setCellValue([9, $rowCounter], 'Gemeente');

        // -- data -----------------------------------------------------------------
        ++$rowCounter;
        foreach ($members as $member) {
            $now = new \DateTimeImmutable();
            $age = $now->diff($member->getDateOfBirth())->y;

            $sheet->setCellValue([1, $rowCounter], 'YK-'.$member->getId());
            $sheet->setCellValue([2, $rowCounter], $member->getLastname());
            $sheet->setCellValue([3, $rowCounter], $member->getFirstname());
            $sheet->setCellValue([4, $rowCounter], $member->getGenderAsString());
            $sheet->setCellValue([5, $rowCounter], $member->getDateOfBirth()->format('d/m/Y'));
            $sheet->setCellValue([6, $rowCounter], $age);
            $sheet->setCellValue([7, $rowCounter], $member->getAddressStreet().' '.$member->getAddressNumber().' '.$member->getAddressBox());
            $sheet->setCellValue([8, $rowCounter], $member->getAddressZip());
            $sheet->setCellValue([9, $rowCounter], $member->getAddressCity());
            ++$rowCounter;
        }

        // -- first row bold ------------------------------------------------------
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle('A1:'.$highestColumn.'1')->getFont()->setBold(true);
        $sheet->setSelectedCell('A1');

        // -- autosize the columns ------------------------------------------------
        for ($i = 'A'; $i != $sheet->getHighestColumn(); ++$i) {
            $sheet->getColumnDimension($i)->setAutoSize(true);
        }
        $sheet->getColumnDimension($sheet->getHighestColumn())->setAutoSize(true);

        return $spreadsheet;
    }

    public function renderMembersForLocation(int $locationId): bool
    {
        $location = $this->locationRepository->getById($locationId);
        $locationCode = $location->getCode();
        $members = $this->memberRepository->getActiveMembersByLocation($location);

        $generatedOn = new \DateTimeImmutable();
        $pdfHtml = $this->twig->render('pdf/list_member.html.twig', [
            'members' => $members,
            'generatedOn' => $generatedOn,
            'locationName' => $location->getName(),
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdfHtml);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $fileName = $generatedOn->format('YmdHis').'_YoshiKan_Leden_'.$locationCode.'.pdf';
        $dompdf->stream($fileName, ['Attachment' => false]);

        exit;

        return true;
    }
}
