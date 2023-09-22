<?php

namespace App\YoshiKan\Application\Query\Member\Readmodel;

class FederationReadModelCollection implements \JsonSerializable
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

    public function addItem(FederationReadModel $readModel)
    {
        $this->collection[] = $readModel;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    /**
     * @return FederationReadModel[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }
}
