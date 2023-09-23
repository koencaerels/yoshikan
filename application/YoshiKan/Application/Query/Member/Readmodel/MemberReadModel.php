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

namespace App\YoshiKan\Application\Query\Member\Readmodel;

use App\YoshiKan\Domain\Model\Member\Member;

class MemberReadModel implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int $id,
        protected string $uuid,
        protected string $status,
        protected string $firstname,
        protected string $lastname,
        protected \DateTimeImmutable $dateOfBirth,
        protected string $gender,
        protected GradeReadModel $grade,
        protected LocationReadModel $location,
        protected string $profileImage,
        protected string $nationalRegisterNumber,
        protected string $email,
        protected string $addressStreet,
        protected string $addressNumber,
        protected string $addressBox,
        protected string $addressZip,
        protected string $addressCity,
        protected FederationReadModel $federation,
        protected \DateTimeImmutable $memberSubscriptionStart,
        protected \DateTimeImmutable $memberSubscriptionEnd,
        protected bool $memberSubscriptionIsPayed,
        protected bool $memberSubscriptionIsHalfYear,
        protected \DateTimeImmutable $licenseStart,
        protected \DateTimeImmutable $licenseEnd,
        protected bool $licenseIsPayed,
        protected string $contactFirstname,
        protected string $contactLastname,
        protected string $contactEmail,
        protected string $contactPhone,
        protected int $numberOfTraining,

        protected ?array $subscriptions = null,
        protected ?string $remarks = null,
        protected ?GradeLogReadModelCollection $gradeLogs = null,
        protected ?MemberImageReadModelCollection $images = null,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // What to render as json
    // —————————————————————————————————————————————————————————————————————————

    public function jsonSerialize(): \stdClass
    {
        $json = new \stdClass();
        $json->id = $this->getId();
        $json->uuid = $this->getUuid();
        $json->status = $this->getStatus();
        $json->firstname = $this->getFirstname();
        $json->lastname = $this->getLastname();
        $json->nationalRegisterNumber = $this->getNationalRegisterNumber();
        $json->dateOfBirth = $this->getDateOfBirth()->format(\DateTimeInterface::ATOM);
        $json->gender = $this->getGender();
        $json->grade = $this->getGrade();
        $json->location = $this->getLocation();
        $json->profileImage = $this->getProfileImage();
        $json->email = $this->getEmail();
        $json->addressStreet = $this->getAddressStreet();
        $json->addressNumber = $this->getAddressNumber();
        $json->addressBox = $this->getAddressBox();
        $json->addressZip = $this->getAddressZip();
        $json->addressCity = $this->getAddressCity();
        $json->federation = $this->getFederation();
        $json->memberSubscriptionStart = $this->getMemberSubscriptionStart()->format(\DateTimeInterface::ATOM);
        $json->memberSubscriptionEnd = $this->getMemberSubscriptionEnd()->format(\DateTimeInterface::ATOM);
        $json->memberSubscriptionIsPayed = $this->isMemberSubscriptionPayed();
        $json->memberSubscriptionIsHalfYear = $this->isMemberSubscriptionIsHalfYear();
        $json->licenseStart = $this->getLicenseStart()->format(\DateTimeInterface::ATOM);
        $json->licenseEnd = $this->getLicenseEnd()->format(\DateTimeInterface::ATOM);
        $json->licenseIsPayed = $this->isLicensePayed();
        $json->contactFirstname = $this->getContactFirstname();
        $json->contactLastname = $this->getContactLastname();
        $json->contactEmail = $this->getContactEmail();
        $json->contactPhone = $this->getContactPhone();
        $json->numberOfTraining = $this->getNumberOfTraining();

        //        if (!is_null($this->getSubscriptions())) {
        //            $json->subscriptions = $this->getSubscriptions()->getCollection();
        //        }

        if (!is_null($this->getRemarks())) {
            $json->remarks = $this->getRemarks();
        }
        if (!is_null($this->getGradeLogs())) {
            $json->gradeLogs = $this->getGradeLogs()->getCollection();
        }
        if (!is_null($this->getImages())) {
            $json->images = $this->getImages()->getCollection();
        }

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from model
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromModel(Member $model, bool $full = false): self
    {
        if ($full) {
            //            $subscriptions = new SubscriptionReadModelCollection([]);
            //            foreach ($model->getSubscriptions() as $subscription) {
            //                $subscriptions->addItem(SubscriptionReadModel::hydrateFromModel($subscription));
            //            }

            $gradeLogs = new GradeLogReadModelCollection([]);
            foreach ($model->getGradeLogs() as $gradeLog) {
                $gradeLogs->addItem(GradeLogReadModel::hydrateFromModel($gradeLog));
            }
            $images = new MemberImageReadModelCollection([]);
            foreach ($model->getMemberImages() as $memberImage) {
                $images->addItem(MemberImageReadModel::hydrateFromModel($memberImage));
            }
            $rm = new self(
                $model->getId(),
                $model->getUuid()->toRfc4122(),
                $model->getStatus()->value,
                $model->getFirstname(),
                $model->getLastname(),
                $model->getDateOfBirth(),
                $model->getGender()->value,
                GradeReadModel::hydrateFromModel($model->getGrade()),
                LocationReadModel::hydrateFromModel($model->getLocation()),
                $model->getProfileImage(),
                $model->getNationalRegisterNumber(),
                $model->getEmail(),
                $model->getAddressStreet(),
                $model->getAddressNumber(),
                $model->getAddressBox(),
                $model->getAddressZip(),
                $model->getAddressCity(),
                FederationReadModel::hydrateFromModel($model->getFederation()),
                $model->getMemberSubscriptionStart(),
                $model->getMemberSubscriptionEnd(),
                $model->isMemberSubscriptionIsPayed(),
                $model->isMemberSubscriptionIsHalfYear(),
                $model->getLicenseStart(),
                $model->getLicenseEnd(),
                $model->licenseIsPayed(),
                $model->getContactFirstname(),
                $model->getContactLastname(),
                $model->getContactEmail(),
                $model->getContactPhone(),
                $model->getNumberOfTraining(),
                [],
                $model->getRemarks(),
                $gradeLogs,
                $images
            );
        } else {
            $rm = new self(
                $model->getId(),
                $model->getUuid()->toRfc4122(),
                $model->getStatus()->value,
                $model->getFirstname(),
                $model->getLastname(),
                $model->getDateOfBirth(),
                $model->getGender()->value,
                GradeReadModel::hydrateFromModel($model->getGrade()),
                LocationReadModel::hydrateFromModel($model->getLocation()),
                $model->getProfileImage(),
                $model->getNationalRegisterNumber(),
                $model->getEmail(),
                $model->getAddressStreet(),
                $model->getAddressNumber(),
                $model->getAddressBox(),
                $model->getAddressZip(),
                $model->getAddressCity(),
                FederationReadModel::hydrateFromModel($model->getFederation()),
                $model->getMemberSubscriptionStart(),
                $model->getMemberSubscriptionEnd(),
                $model->isMemberSubscriptionIsPayed(),
                $model->isMemberSubscriptionIsHalfYear(),
                $model->getLicenseStart(),
                $model->getLicenseEnd(),
                $model->licenseIsPayed(),
                $model->getContactFirstname(),
                $model->getContactLastname(),
                $model->getContactEmail(),
                $model->getContactPhone(),
                $model->getNumberOfTraining(),
            );
        }

        return $rm;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getDateOfBirth(): \DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getGrade(): GradeReadModel
    {
        return $this->grade;
    }

    public function getLocation(): LocationReadModel
    {
        return $this->location;
    }

    public function getSubscriptions(): ?array
    {
        return $this->subscriptions;
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function getGradeLogs(): ?GradeLogReadModelCollection
    {
        return $this->gradeLogs;
    }

    public function getImages(): ?MemberImageReadModelCollection
    {
        return $this->images;
    }

    public function getProfileImage(): string
    {
        return $this->profileImage;
    }

    public function getNationalRegisterNumber(): string
    {
        return $this->nationalRegisterNumber;
    }

    public function getAddressStreet(): string
    {
        return $this->addressStreet;
    }

    public function getAddressNumber(): string
    {
        return $this->addressNumber;
    }

    public function getAddressBox(): string
    {
        return $this->addressBox;
    }

    public function getAddressZip(): string
    {
        return $this->addressZip;
    }

    public function getAddressCity(): string
    {
        return $this->addressCity;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFederation(): FederationReadModel
    {
        return $this->federation;
    }

    public function getMemberSubscriptionStart(): \DateTimeImmutable
    {
        return $this->memberSubscriptionStart;
    }

    public function getMemberSubscriptionEnd(): \DateTimeImmutable
    {
        return $this->memberSubscriptionEnd;
    }

    public function isMemberSubscriptionPayed(): bool
    {
        return $this->memberSubscriptionIsPayed;
    }

    public function getLicenseStart(): \DateTimeImmutable
    {
        return $this->licenseStart;
    }

    public function getLicenseEnd(): \DateTimeImmutable
    {
        return $this->licenseEnd;
    }

    public function isLicensePayed(): bool
    {
        return $this->licenseIsPayed;
    }

    public function isMemberSubscriptionIsHalfYear(): bool
    {
        return $this->memberSubscriptionIsHalfYear;
    }

    public function getContactFirstname(): string
    {
        return $this->contactFirstname;
    }

    public function getContactLastname(): string
    {
        return $this->contactLastname;
    }

    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    public function getNumberOfTraining(): int
    {
        return $this->numberOfTraining;
    }
}
