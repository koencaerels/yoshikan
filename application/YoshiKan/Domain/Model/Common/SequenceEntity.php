<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Common;

use Doctrine\ORM\Mapping as ORM;

trait SequenceEntity
{
    #[ORM\Column(options: ["default" => 0])]
    private int $sequence = 0;

    // ———————————————————————————————————————————————————————————————————
    // Getters and setters
    // ———————————————————————————————————————————————————————————————————

    public function getSequence(): int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): void
    {
        $this->sequence = $sequence;
    }
}
