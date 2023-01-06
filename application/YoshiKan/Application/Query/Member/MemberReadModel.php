<?php

declare(strict_types=1);

namespace App\YoshiKan\Application\Query\Member;

use App\YoshiKan\Domain\Model\Member\Member;

class MemberReadModel implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int                              $id,
        protected string                           $uuid,
        protected string                           $status,
        protected string                           $firstname,
        protected string                           $lastname,
        protected \DateTimeImmutable               $dateOfBirth,
        protected string                           $gender,
        protected GradeReadModel                   $grade,
        protected LocationReadModel                $location,
        protected ?SubscriptionReadModelCollection $subscriptions = null,
        protected ?string                          $remarks = null,
        protected ?GradeLogReadModelCollection     $gradeLogs = null
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
        $json->dateOfBirth = $this->getDateOfBirth()->format(\DateTimeInterface::ATOM);
        $json->gender = $this->getGender();
        $json->grade = $this->getGrade();
        $json->location = $this->getLocation();
        if (!is_null($this->getSubscriptions())) {
            $json->subscriptions = $this->getSubscriptions()->getCollection();
        }
        if (!is_null($this->getRemarks())) {
            $json->remarks = $this->getRemarks();
        }
        if (!is_null($this->getGradeLogs())) {
            $json->gradeLogs = $this->getGradeLogs()->getCollection();
        }

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from model
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromModel(Member $model, bool $full = false): self
    {
        if ($full) {
            $subscriptions = new SubscriptionReadModelCollection([]);
            foreach ($model->getSubscriptions() as $subscription) {
                $subscriptions->addItem(SubscriptionReadModel::hydrateFromModel($subscription));
            }
            $gradeLogs = new GradeLogReadModelCollection([]);
            foreach ($model->getGradeLogs() as $gradeLog) {
                $gradeLogs->addItem(GradeLogReadModel::hydrateFromModel($gradeLog));
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
                $subscriptions,
                $model->getRemarks(),
                $gradeLogs
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

    public function getSubscriptions(): ?SubscriptionReadModelCollection
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
}
