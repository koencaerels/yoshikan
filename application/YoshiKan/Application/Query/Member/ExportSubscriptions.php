<?php

namespace App\YoshiKan\Application\Query\Member;

use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExportSubscriptions
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected PeriodRepository       $periodRepository
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
        $sheet->setCellValue([2, $rowCounter], 'Voornaam');
        $sheet->setCellValue([3, $rowCounter], 'Naam');
        $sheet->setCellValue([4, $rowCounter], 'Geboortedatum');
        $sheet->setCellValue([5, $rowCounter], 'Geslacht');
        $sheet->setCellValue([6, $rowCounter], 'Lidnr.');
        $sheet->setCellValue([7, $rowCounter], 'Graad');
        $sheet->setCellValue([8, $rowCounter], 'Contact');
        $sheet->setCellValue([9, $rowCounter], 'Email');

        // -- data -----------------------------------------------------------------
        $rowCounter++;
        foreach ($subscriptions as $subscription) {
            $sheet->setCellValue([1, $rowCounter], 'YKS-' . $subscription->getId());
            $sheet->setCellValue([2, $rowCounter], $subscription->getFirstname());
            $sheet->setCellValue([3, $rowCounter], $subscription->getLastname());
            $sheet->setCellValue([4, $rowCounter], $subscription->getDateOfBirth()->format('d/m/Y'));
            $sheet->setCellValue([5, $rowCounter], $subscription->getGenderAsString());
            $sheet->setCellValue([6, $rowCounter], 'YK-' . $subscription->getMember()->getId());
            $sheet->setCellValue([7, $rowCounter], $subscription->getMember()->getGrade()->getName());
            $sheet->setCellValue([8, $rowCounter], $subscription->getContactFirstname() . ' ' . $subscription->getContactLastname());
            $sheet->setCellValue([9, $rowCounter], $subscription->getContactEmail());
            $rowCounter++;
        }

        // -- first row bold ------------------------------------------------------
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle('A1:' . $highestColumn . '1' )->getFont()->setBold(true);
        $sheet->setSelectedCell('A1');

        // -- autosize the columns ------------------------------------------------
        for ($i = 'A'; $i != $sheet->getHighestColumn(); $i++) {
            $sheet->getColumnDimension($i)->setAutoSize(TRUE);
        }

        return $spreadsheet;
    }
}
