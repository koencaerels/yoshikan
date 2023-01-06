<?php

declare(strict_types=1);

namespace App\YoshiKan\Application\Query\Member;

use App\YoshiKan\Domain\Model\Member\GradeLog;

class GradeLogReadModel implements \JsonSerializable
{

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int $id,
        protected string $uuid,
        protected \DateTimeImmutable $date,
        protected string $remark,
        protected GradeReadModel $fromGrade,
        protected GradeReadModel $toGrade,
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
        $json->date = $this->getDate()->format(\DateTimeInterface::ATOM);
        $json->remark = $this->getRemark();
        $json->fromGrade = $this->getFromGrade();
        $json->toGrade = $this->getToGrade();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from model
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromModel(GradeLog $model): self
    {
        return new self(
            $model->getId(),
            $model->getUuid()->toRfc4122(),
            $model->getDate(),
            $model->getRemark(),
            GradeReadModel::hydrateFromModel($model->getFromGrade()),
            GradeReadModel::hydrateFromModel($model->getToGrade()),
        );
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

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getRemark(): string
    {
        return $this->remark;
    }

    public function getFromGrade(): GradeReadModel
    {
        return $this->fromGrade;
    }

    public function getToGrade(): GradeReadModel
    {
        return $this->toGrade;
    }

}
