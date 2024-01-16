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

namespace App\YoshiKan\Application\Command\Import\ImportActiveMember;

use App\YoshiKan\Application\Command\Common\SubscriptionItemsFactory;
use App\YoshiKan\Application\Command\Import\Mapping\GradeMapping;
use App\YoshiKan\Application\Command\Import\Mapping\LocationMapping;
use App\YoshiKan\Application\Query\Member\Readmodel\SettingsReadModel;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SettingsCode;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionItemRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;
use App\YoshiKan\Domain\Model\Member\SubscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportActiveMembersHandler
{
    public function __construct(
        protected string $srcFile,
        protected EntityManagerInterface $entityManager,
        protected MemberRepository $memberRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected FederationRepository $federationRepository,
        protected LocationRepository $locationRepository,
        protected GradeRepository $gradeRepository,
        protected SettingsRepository $settingsRepository,
        protected SubscriptionItemRepository $subscriptionItemRepository,
    ) {
    }

    public function import(): bool
    {
        $reader = new Xlsx();
        $reader->setLoadSheetsOnly(['Gegevens']);
        $spreadsheet = $reader->load($this->srcFile);

        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        for ($row = 2; $row <= $highestRow; ++$row) {
            $isNewMember = false;

            $dto = new \stdClass();
            $dto->firstName = (string) $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $dto->lastName = mb_strtoupper($worksheet->getCellByColumnAndRow(1, $row)->getValue());
            $dto->dateOfBirth = Date::excelToDateTimeObject($worksheet->getCellByColumnAndRow(4, $row)->getValue())->format(\DateTimeInterface::ATOM);
            $dto->nationalNumber = (string) $worksheet->getCellByColumnAndRow(5, $row)->getValue();
            $dto->street = (string) $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            $dto->city = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
            $dto->postalCode = (string) $worksheet->getCellByColumnAndRow(7, $row)->getValue();
            $dto->contactPhone = (string) $worksheet->getCellByColumnAndRow(8, $row)->getValue();
            $dto->contactEmail = (string) $worksheet->getCellByColumnAndRow(9, $row)->getValue();
            $dto->gender = Gender::X;
            $dto->location = $this->locationRepository->getById(LocationMapping::getLocationId($worksheet->getCellByColumnAndRow(26, $row)->getValue()));
            $dto->grade = $this->gradeRepository->getById(GradeMapping::getGradeId($worksheet->getCellByColumnAndRow(25, $row)->getValue()));
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

            $dto->memberShipStart = new \DateTimeImmutable(sprintf('%s-%s-01', $dto->memberShipStartYY, $dto->memberShipStartMM));
            $dto->memberShipEnd = new \DateTimeImmutable(sprintf('%s-%s-01', $dto->memberShipEndYY, $dto->memberShipEndMM));

            $dto->licenseStartMM = (int) $worksheet->getCellByColumnAndRow(16, $row)->getValue();
            $dto->licenseStartYY = (int) $worksheet->getCellByColumnAndRow(17, $row)->getValue();
            $dto->licenseEndMM = (int) $worksheet->getCellByColumnAndRow(18, $row)->getValue();
            $dto->licenseEndYY = (int) $worksheet->getCellByColumnAndRow(19, $row)->getValue();
            $dto->licenseAmount = (float) $worksheet->getCellByColumnAndRow(20, $row)->getValue();
            $dto->licenseIsPayed = (bool) $worksheet->getCellByColumnAndRow(21, $row)->getValue();
            $dto->licenseShipStart = new \DateTimeImmutable(sprintf('%s-%s-01', $dto->licenseStartYY, $dto->licenseStartMM));
            $dto->licenseShipEnd = new \DateTimeImmutable(sprintf('%s-%s-01', $dto->licenseEndYY, $dto->licenseEndMM));

            // -- determine subscription type -----------------------------------

            $subscriptionType = SubscriptionType::RENEWAL_FULL;
            $dto->newMemberShipAmount = $dto->memberShipAmount;
            $dto->newLicenseAmount = $dto->licenseAmount;
            $dto->licenseIsPartSubscription = true;
            $dto->memberSubscriptionIsPartSubscription = true;

            if ($dto->memberShipIsPayed && !$dto->licenseIsPayed) {
                $dto->newMemberShipAmount = 0;
                $subscriptionType = SubscriptionType::RENEWAL_LICENSE;
                $dto->memberSubscriptionIsPartSubscription = false;
            }
            if (!$dto->memberShipIsPayed && $dto->licenseIsPayed) {
                $dto->newLicenseAmount = 0;
                $subscriptionType = SubscriptionType::RENEWAL_MEMBERSHIP;
                $dto->licenseIsPartSubscription = false;
            }

            // -- determine number of training sessions ------------------------

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

            // -- search for existing member -----------------------------------

            $member = $this->memberRepository->findByNameAndDateOfBirth($dto->firstName, $dto->lastName, new \DateTimeImmutable($dto->dateOfBirth));
            if (true === is_null($member)) {
                $isNewMember = true;
                $member = Member::make(
                    uuid: $this->memberRepository->nextIdentity(),
                    firstname: ucfirst(mb_strtolower($dto->firstName)),
                    lastname: mb_strtoupper($dto->lastName),
                    dateOfBirth: new \DateTimeImmutable($dto->dateOfBirth),
                    gender: $dto->gender,
                    grade: $dto->grade,
                    location: $dto->location,
                    federation: $dto->federation,
                    email: $dto->contactEmail,
                    nationalRegisterNumber: $dto->nationalNumber,
                    addressStreet: $dto->street,
                    addressNumber: '',
                    addressBox: '',
                    addressZip: $dto->postalCode,
                    addressCity: $dto->city,
                    numberOfTraining: $dto->numberOfTrainingSessions,
                );
            }

            // -- sync member subscription details ----------------------------

            $member->syncFromSubscription(
                federation: $dto->federation,
                numberOfTraining: $dto->numberOfTrainingSessions,
                isHalfYearSubscription: $dto->memberSubscriptionIsHalfYear,
            );

            $member->changeGrade($dto->grade);
            $member->setContactInformation(
                contactFirstname: ucfirst(mb_strtolower($dto->firstName)),
                contactLastname: mb_strtoupper($dto->lastName),
                contactEmail: $dto->contactEmail,
                contactPhone: $dto->contactPhone,
            );
            $member->setSubscriptionDates(
                start: $dto->memberShipStart,
                end: $dto->memberShipEnd,
                isHalfYearSubscription: $dto->memberSubscriptionIsHalfYear
            );
            if ($dto->memberShipIsPayed) {
                $member->markSubscriptionAsPayed();
            }
            $member->setLicenseDates(
                start: $dto->licenseShipStart,
                end: $dto->licenseShipEnd,
            );
            if ($dto->licenseIsPayed) {
                $member->markLicenseAsPayed();
            }
            $member->activate();
            $this->memberRepository->save($member);
            $this->entityManager->flush();

            echo '-> member created / saved ->'.$member->getUuidAsString();

            $subscription = $this->subscriptionRepository->findByMemberAndDatesAndAmounts(
                member: $member,
                memberStartDate: $dto->memberShipStart,
                memberEndDate: $dto->memberShipEnd,
                licenseStartDate: $dto->licenseShipStart,
                licenseEndDate: $dto->licenseShipEnd,
                memberShipAmount: $dto->memberShipAmount,
                licenseAmount: $dto->licenseAmount,
            );

            // -- create a subscription ----------------------------------------

            $settings = $this->settingsRepository->findByCode(SettingsCode::ACTIVE->value);

            if (true === is_null($subscription)) {
                $subscription = Subscription::make(
                    uuid: $this->subscriptionRepository->nextIdentity(),
                    contactFirstname: ucfirst(mb_strtolower($dto->firstName)),
                    contactLastname: mb_strtoupper($dto->lastName),
                    contactEmail: $dto->contactEmail,
                    contactPhone: $dto->contactPhone,
                    firstname: ucfirst(mb_strtolower($dto->firstName)),
                    lastname: mb_strtoupper($dto->lastName),
                    dateOfBirth: new \DateTimeImmutable($dto->dateOfBirth),
                    gender: $dto->gender,
                    type: $subscriptionType,
                    numberOfTraining: $dto->numberOfTrainingSessions,
                    isExtraTraining: false,
                    isNewMember: $isNewMember,
                    isReductionFamily: false,
                    isJudogiBelt: false,
                    remarks: 'Active subscription',
                    location: $dto->location,
                    settings: json_decode(json_encode(SettingsReadModel::hydrateFromModel($settings)), true),
                    federation: $dto->federation,
                    memberSubscriptionStart: $dto->memberShipStart,
                    memberSubscriptionEnd: $dto->memberShipEnd,
                    memberSubscriptionTotal: $dto->newMemberShipAmount,
                    memberSubscriptionIsPartSubscription: $dto->memberSubscriptionIsPartSubscription,
                    memberSubscriptionIsHalfYear: $dto->memberSubscriptionIsHalfYear,
                    memberSubscriptionIsPayed: $dto->memberShipIsPayed,
                    licenseStart: $dto->licenseShipStart,
                    licenseEnd: $dto->licenseShipEnd,
                    licenseTotal: $dto->newLicenseAmount,
                    licenseIsPartSubscription: $dto->licenseIsPartSubscription,
                    licenseIsPayed: $dto->licenseIsPayed,
                );
            } else {
                $subscription->fullChange(
                    contactFirstname: ucfirst(mb_strtolower($dto->firstName)),
                    contactLastname: mb_strtoupper($dto->lastName),
                    contactEmail: $dto->contactEmail,
                    contactPhone: $dto->contactPhone,
                    firstname: ucfirst(mb_strtolower($dto->firstName)),
                    lastname: mb_strtoupper($dto->lastName),
                    dateOfBirth: new \DateTimeImmutable($dto->dateOfBirth),
                    gender: $dto->gender,
                    type: $subscriptionType,
                    numberOfTraining: $dto->numberOfTrainingSessions,
                    isExtraTraining: (3 === $dto->numberOfTrainingSessions),
                    isNewMember: false,
                    isReductionFamily: false,
                    isJudogiBelt: false,
                    remarks: 'Active subscription on import',
                    location: $dto->location,
                    federation: $dto->federation,
                    memberSubscriptionStart: $dto->memberShipStart,
                    memberSubscriptionEnd: $dto->memberShipEnd,
                    memberSubscriptionTotal: $dto->newMemberShipAmount,
                    memberSubscriptionIsPartSubscription: $dto->memberSubscriptionIsPartSubscription,
                    memberSubscriptionIsHalfYear: $dto->memberSubscriptionIsHalfYear,
                    memberSubscriptionIsPayed: $dto->memberShipIsPayed,
                    licenseStart: $dto->licenseShipStart,
                    licenseEnd: $dto->licenseShipEnd,
                    licenseTotal: $dto->newLicenseAmount,
                    licenseIsPartSubscription: $dto->licenseIsPartSubscription,
                    licenseIsPayed: $dto->licenseIsPayed,
                );
            }

            // make awaiting payment subscription
            $subscription->setMember($member);
            $subscription->setTotal($dto->newMemberShipAmount + $dto->newLicenseAmount);
            $subscription->changeStatus(SubscriptionStatus::AWAITING_PAYMENT);
            $subscription->updateSettings(json_decode(json_encode(SettingsReadModel::hydrateFromModel($settings)), true));
            $this->subscriptionRepository->save($subscription);

            if ($dto->memberShipIsPayed && $dto->licenseIsPayed) {
                $subscription->changeStatus(SubscriptionStatus::PAYED);
            }

            // -- make some subscription lines -------------------------------------------------------------------------

            $subscriptionItemFactory = new SubscriptionItemsFactory(
                $this->subscriptionRepository,
                $this->subscriptionItemRepository
            );
            $resultItems = $subscriptionItemFactory->saveItemsFromSubscription(
                $subscription,
                $dto->federation,
                $settings,
            );

            $this->entityManager->flush();
            echo '<strong>-> subscription saved / updated </strong> ->'.$subscription->getUuidAsString();
            ob_flush();
            flush();
        }

        echo '<br>Done';
        exit;

        return true;
    }
}
