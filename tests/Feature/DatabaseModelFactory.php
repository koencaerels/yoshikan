<?php

namespace App\Tests\Feature;

use Doctrine\ORM\EntityManagerInterface;

class DatabaseModelFactory
{
    public function __construct(protected EntityManagerInterface $em)
    {
    }
}
