<?php

declare(strict_types=1);

namespace App\YoshiKan\Application\Query\Member;

class GroupReadModelCollection implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(protected array $collection)
    {
        $this->collection = [];
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

    public function addItem(GroupReadModel $readModel)
    {
        $this->collection[] = $readModel;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    /**
     * @return GroupReadModel[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }
}
