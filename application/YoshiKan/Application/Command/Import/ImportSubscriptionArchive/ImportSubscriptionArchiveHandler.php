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

namespace App\YoshiKan\Application\Command\Import\ImportSubscriptionArchive;

use App\YoshiKan\Application\Command\Import\Mapping\GradeMapping;
use App\YoshiKan\Application\Command\Import\Mapping\LocationMapping;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\MemberStatus;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;
use App\YoshiKan\Domain\Model\Member\SubscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportSubscriptionArchiveHandler
{
    public function __construct(
        protected string $srcFile,
        protected EntityManagerInterface $entityManager,
        protected MemberRepository $memberRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected FederationRepository $federationRepository,
        protected LocationRepository $locationRepository,
        protected GradeRepository $gradeRepository,
    ) {
    }

    public function import(): bool
    {
        $reader = new Xlsx();
        $reader->setLoadSheetsOnly(['Logging']);
        $spreadsheet = $reader->load($this->srcFile);

        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        echo '<br>'.$highestRow;

        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        // $highestRow = 20;
        $startRow = 9000;

        for ($row = $startRow; $row <= $highestRow; ++$row) {
            $dto = new \stdClass();
            $dto->firstName = (string) $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $dto->lastName = strtoupper((string) $worksheet->getCellByColumnAndRow(1, $row)->getValue());
            $dto->dateOfBirth = Date::excelToDateTimeObject($worksheet->getCellByColumnAndRow(3, $row)->getValue())->format(\DateTimeInterface::ATOM);

            $dto->street = (string) $worksheet->getCellByColumnAndRow(5, $row)->getValue();
            $dto->city = (string) $worksheet->getCellByColumnAndRow(6, $row)->getValue();
            $dto->postalCode = (string) $worksheet->getCellByColumnAndRow(7, $row)->getValue();
            $dto->contactPhone = (string) $worksheet->getCellByColumnAndRow(8, $row)->getValue();
            $dto->contactEmail = (string) $worksheet->getCellByColumnAndRow(9, $row)->getValue();
            $dto->gender = Gender::X;
            $dto->location = $this->locationRepository->getById(LocationMapping::getLocationId((string) $worksheet->getCellByColumnAndRow(26, $row)->getValue()));
            $dto->grade = $this->gradeRepository->getById(GradeMapping::getGradeId((string) $worksheet->getCellByColumnAndRow(25, $row)->getValue()));
            $dto->sporta = (bool) $worksheet->getCellByColumnAndRow(23, $row)->getValue();
            $dto->jv = (bool) $worksheet->getCellByColumnAndRow(24, $row)->getValue();
            if ($dto->sporta) {
                $dto->federation = $this->federationRepository->getById(2);
            } else {
                $dto->federation = $this->federationRepository->getById(1);
            }

            $dto->memberShipStartMM = (int) $worksheet->getCellByColumnAndRow(10, $row)->getValue();
            $dto->memberShipStartYY = (int) $worksheet->getCellByColumnAndRow(11, $row)->getValue();
            $dto->memberShipEndMM = (int) $worksheet->getCellByColumnAndRow(12, $row)->getValue();
            $dto->memberShipEndYY = (int) $worksheet->getCellByColumnAndRow(13, $row)->getValue();
            $dto->memberShipAmount = (float) $worksheet->getCellByColumnAndRow(14, $row)->getValue();
            $dto->memberShipIsPayed = (bool) $worksheet->getCellByColumnAndRow(15, $row)->getValue();

            if (0 === $dto->memberShipStartMM || is_null($dto->memberShipStartMM)) {
                $dto->memberShipStart = new \DateTimeImmutable('2000-01-01');
                $dto->memberShipEnd = new \DateTimeImmutable('2001-01-01');
            } else {
                try {
                    $dto->memberShipStart = new \DateTimeImmutable(sprintf('%s-%s-01', $dto->memberShipStartYY, $dto->memberShipStartMM));
                    $dto->memberShipEnd = new \DateTimeImmutable(sprintf('%s-%s-01', $dto->memberShipEndYY, $dto->memberShipEndMM));
                } catch (\Exception $e) {
                    $dto->memberShipStart = new \DateTimeImmutable('2000-01-01');
                    $dto->memberShipEnd = new \DateTimeImmutable('2001-01-01');
                }
            }

            $dto->licenseStartMM = (int) $worksheet->getCellByColumnAndRow(16, $row)->getValue();
            $dto->licenseStartYY = (int) $worksheet->getCellByColumnAndRow(17, $row)->getValue();
            $dto->licenseEndMM = (int) $worksheet->getCellByColumnAndRow(18, $row)->getValue();
            $dto->licenseEndYY = (int) $worksheet->getCellByColumnAndRow(19, $row)->getValue();
            $dto->licenseAmount = (float) $worksheet->getCellByColumnAndRow(20, $row)->getValue();
            $dto->licenseIsPayed = (bool) $worksheet->getCellByColumnAndRow(21, $row)->getValue();

            if (0 === $dto->licenseStartMM || is_null($dto->licenseStartMM)) {
                $dto->licenseShipStart = new \DateTimeImmutable('2000-01-01');
                $dto->licenseShipEnd = new \DateTimeImmutable('2001-01-01');
            } else {
                try {
                    $dto->licenseShipStart = new \DateTimeImmutable(sprintf('%s-%s-01', $dto->licenseStartYY, $dto->licenseStartMM));
                    $dto->licenseShipEnd = new \DateTimeImmutable(sprintf('%s-%s-01', $dto->licenseEndYY, $dto->licenseEndMM));
                } catch (\Exception $e) {
                    $dto->licenseShipStart = new \DateTimeImmutable('2000-01-01');
                    $dto->licenseShipEnd = new \DateTimeImmutable('2001-01-01');
                }
            }

            $interval = $dto->memberShipEnd->diff($dto->memberShipStart);
            if ($interval->days > 360) {
                $dto->memberSubscriptionIsHalfYear = false;
            } else {
                $dto->memberSubscriptionIsHalfYear = true;
            }
            if ($dto->memberShipAmount >= 275) {
                $dto->numberOfTrainingSessions = 3;
            } elseif ($dto->memberShipAmount >= 140) {
                $dto->numberOfTrainingSessions = 2;
            } else {
                $dto->numberOfTrainingSessions = 1;
            }

            echo '<br>'.$dto->firstName.' '.$dto->lastName;
            ob_flush();
            flush();

            $dateOfBirthCheck = new \DateTimeImmutable($dto->dateOfBirth);
            if ('19700101' === $dateOfBirthCheck->format('Ymd')) {
                echo '-> skipped';
                continue;
            }

            $member = $this->memberRepository->findByNameAndDateOfBirth($dto->firstName, $dto->lastName, new \DateTimeImmutable($dto->dateOfBirth));
            if (true === is_null($member)) {
                $member = Member::make(
                    uuid: $this->memberRepository->nextIdentity(),
                    firstname: ucfirst(strtolower($dto->firstName)),
                    lastname: strtoupper($dto->lastName),
                    dateOfBirth: new \DateTimeImmutable($dto->dateOfBirth),
                    gender: $dto->gender,
                    grade: $dto->grade,
                    location: $dto->location,
                    federation: $dto->federation,
                    email: $dto->contactEmail,
                    nationalRegisterNumber: '',
                    addressStreet: $dto->street,
                    addressNumber: '',
                    addressBox: '',
                    addressZip: $dto->postalCode,
                    addressCity: $dto->city,
                    numberOfTraining: $dto->numberOfTrainingSessions,
                );
            } else {
                $member->changeDetails(
                    firstname: ucfirst(strtolower($dto->firstName)),
                    lastname: strtoupper($dto->lastName),
                    gender: $dto->gender,
                    dateOfBirth: new \DateTimeImmutable($dto->dateOfBirth),
                    status: MemberStatus::ACTIVE,
                    location: $dto->location,
                    nationalRegisterNumber: '',
                    email: $dto->contactEmail,
                    addressStreet: $dto->street,
                    addressNumber: '',
                    addressBox: '',
                    addressZip: $dto->postalCode,
                    addressCity: $dto->city,
                    contactFirstname: ucfirst(strtolower($dto->firstName)),
                    contactLastname: strtoupper($dto->lastName),
                    contactEmail: $dto->contactEmail,
                    contactPhone: $dto->contactPhone,
                );
            }
            // set some member properties

            $member->changeGrade($dto->grade);
            $member->setContactInformation(
                contactFirstname: ucfirst(strtolower($dto->firstName)),
                contactLastname: strtoupper($dto->lastName),
                contactEmail: $dto->contactEmail,
                contactPhone: $dto->contactPhone,
            );
            $member->setSubscriptionDates(
                start: $dto->memberShipStart,
                end: $dto->memberShipEnd,
                isHalfYearSubscription: $dto->memberSubscriptionIsHalfYear
            );
            $member->markSubscriptionAsPayed();
            $member->setLicenseDates(
                start: $dto->licenseShipStart,
                end: $dto->licenseShipEnd,
            );
            $member->markLicenseAsPayed();
            $member->deactivate();
            $this->memberRepository->save($member);
            $this->entityManager->flush();

            echo '-> member saved ->'.$member->getUuidAsString();
            ob_flush();
            flush();

            $subscription = $this->subscriptionRepository->findByMemberAndDatesAndAmounts(
                member: $member,
                memberStartDate: $dto->memberShipStart,
                memberEndDate: $dto->memberShipEnd,
                licenseStartDate: $dto->licenseShipStart,
                licenseEndDate: $dto->licenseShipEnd,
                memberShipAmount: $dto->memberShipAmount,
                licenseAmount: $dto->licenseAmount,
            );
            if (true === is_null($subscription)) {
                $subscription = Subscription::make(
                    uuid: $this->subscriptionRepository->nextIdentity(),
                    contactFirstname: ucfirst(strtolower($dto->firstName)),
                    contactLastname: strtoupper($dto->lastName),
                    contactEmail: $dto->contactEmail,
                    contactPhone: $dto->contactPhone,
                    firstname: ucfirst(strtolower($dto->firstName)),
                    lastname: strtoupper($dto->lastName),
                    dateOfBirth: new \DateTimeImmutable($dto->dateOfBirth),
                    gender: $dto->gender,
                    type: SubscriptionType::RENEWAL_FULL,
                    numberOfTraining: $dto->numberOfTrainingSessions,
                    isExtraTraining: false,
                    isNewMember: false,
                    isReductionFamily: false,
                    isJudogiBelt: false,
                    remarks: 'archive import',
                    location: $dto->location,
                    settings: [],
                    federation: $dto->federation,
                    memberSubscriptionStart: $dto->memberShipStart,
                    memberSubscriptionEnd: $dto->memberShipEnd,
                    memberSubscriptionTotal: $dto->memberShipAmount,
                    memberSubscriptionIsPartSubscription: true,
                    memberSubscriptionIsHalfYear: $dto->memberSubscriptionIsHalfYear,
                    memberSubscriptionIsPayed: false,
                    licenseStart: $dto->licenseShipStart,
                    licenseEnd: $dto->licenseShipEnd,
                    licenseTotal: $dto->licenseAmount,
                    licenseIsPartSubscription: true,
                    licenseIsPayed: false,
                );
            }

            // make archive subscription
            $subscription->setMember($member);
            $subscription->changeStatus(SubscriptionStatus::ARCHIVED);
            $this->subscriptionRepository->save($subscription);
            $this->entityManager->flush();
            echo '<strong>-> subscription saved / updated </strong> ->'.$subscription->getUuidAsString();
            ob_flush();
            flush();
        }

        exit;

        return true;
    }

    public function importGrades(): bool
    {
        $reader = new Xlsx();
        $reader->setLoadSheetsOnly(['Logging']);
        $spreadsheet = $reader->load($this->srcFile);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        echo '<br>'.$highestRow;

        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        // $highestRow = 20;
        $startRow = 2;

        for ($row = $startRow; $row <= $highestRow; ++$row) {
            $dto = new \stdClass();
            $dto->firstName = (string) $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $dto->lastName = strtoupper((string) $worksheet->getCellByColumnAndRow(1, $row)->getValue());
            $dto->dateOfBirth = Date::excelToDateTimeObject($worksheet->getCellByColumnAndRow(3, $row)->getValue())->format(\DateTimeInterface::ATOM);
            $dto->grade = $this->gradeRepository->getById(GradeMapping::getGradeId((string) $worksheet->getCellByColumnAndRow(25, $row)->getValue()));

            echo '<br>'.$dto->firstName.' '.$dto->lastName;
            ob_flush();
            flush();

            $dateOfBirthCheck = new \DateTimeImmutable($dto->dateOfBirth);
            if ('19700101' === $dateOfBirthCheck->format('Ymd')) {
                echo '-> skipped';
                continue;
            }

            $member = $this->memberRepository->findByNameAndDateOfBirth($dto->firstName, $dto->lastName, new \DateTimeImmutable($dto->dateOfBirth));
            if (false === is_null($member)) {
                if (1 !== $dto->grade->getId()) {
                    $member->changeGrade($dto->grade);
                    $this->memberRepository->save($member);
                    $this->entityManager->flush();
                    echo '<strong>-> GC -></strong>'.$dto->grade->getName();
                    ob_flush();
                    flush();
                }
            }
        }

        exit;

        return true;
    }
}
