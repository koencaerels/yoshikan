<?php

declare(strict_types=1);

namespace App\YoshiKan\Application\Query\Member;

class MemberReadModelCollection implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(protected array $collection = [])
    {
    }

    // —————————————————————————————————————————————————————————————————————————
    // What to render as json
    // —————————————————————————————————————————————————————————————————————————

    public function jsonSerialize(): \stdClass
    {
        $json = new \stdClass();
        $json->collection = $this->getCollection();

        return $json;
    }

    public function addItem(MemberReadModel $readModel)
    {
        $this->collection[] = $readModel;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————
    /**
     * @return MemberReadModel[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }
}
