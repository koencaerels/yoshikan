<?php

namespace App\Tests\integration;

use Doctrine\ORM\EntityManagerInterface;

class DatabaseModelFactory
{
    public function __construct(protected EntityManagerInterface $em)
    {
    }
}
